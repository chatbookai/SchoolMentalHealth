<?php
require_once('config.inc.php');

$HTTP_ORIGIN    = $_SERVER['HTTP_ORIGIN'];
if (in_array($HTTP_ORIGIN, $allowedOrigins)) {
    header("Access-Control-Allow-Origin:" . $HTTP_ORIGIN);
}
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, cache-control, Authorization, X-Requested-With, satoken");
header("Content-type: text/html; charset=utf-8");
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$_POST = json_decode(file_get_contents("php://input"), true);

if($_POST['action'] == 'stream' && $_POST['subject'] != '')   {
    
    $subject = $_POST['subject'];

    $promptText = "
      请为“".$subject."”生成一个详细的PPT大纲，涵盖内容请根据topic提供的信息生成一份与时俱进的完美的ppt大纲。大纲应包含主要章节，每个章节下有子章节，每个子章节进一步细分为几个小点。小点的数量应根据主题的复杂性灵活调整，最多不超过6个。如果“".$subject."”里面有要求子章节和小点的数量，请根据要求生成对应的子章节数量和小点数量。请遵循以下格式：

      ".$subject."
      1. 主要章节
        1.1 子章节
          1.1.1 小点
          1.1.2 小点
          1.1.3 小点
          1.1.4 小点
          1.1.5 小点
          1.1.6 小点

      ...请严格遵守上面的格式生成适合“".$subject."”的内容，不要更改格式。
    ";

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => $API_URL . '/chat/completions',
    CURLOPT_RETURNTRANSFER => false, // 不返回整个响应
    CURLOPT_WRITEFUNCTION => function($curl, $data) {
        echo $data; // 逐字输出数据
        ob_flush();
        flush();
        return strlen($data); // 返回数据长度
    },
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "model": "'.$API_MODE.'",
        "messages": [
        {
            "role": "user",
            "content": "'.$subject.'"
        }
        ],
        "frequency_penalty": 0,
        "max_tokens": 2048,
        "presence_penalty": 0,
        "response_format": {
            "type": "text"
        },
        "stop": null,
        "stream": true,
        "stream_options": null,
        "temperature": 0,
        "top_p": 1,
        "tools": null,
        "tool_choice": "none",
        "logprobs": false,
        "top_logprobs": null
    }',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $API_KEY
    ),
    ));

    curl_exec($curl);
    curl_close($curl);
    ob_flush();
    flush();

}

?>