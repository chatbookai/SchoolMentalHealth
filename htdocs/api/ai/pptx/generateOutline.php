<?php
require_once('config.inc.php');

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.deepseek.com/chat/completions',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "messages": [
    {
      "content": "你好,请介绍一下React",
      "role": "user"
    }
  ],
  "model": "deepseek-chat",
  "frequency_penalty": 0,
  "max_tokens": 2048,
  "presence_penalty": 0,
  "response_format": {
    "type": "text"
  },
  "stop": null,
  "stream": false,
  "stream_options": null,
  "temperature": 1,
  "top_p": 1,
  "tools": null,
  "tool_choice": "none",
  "logprobs": false,
  "top_logprobs": null
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Bearer sk-a3dafc724335489e94a30f495dcb10d8'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;


if($_GET['action'] == "stream")  {


}

if($_GET['action'] == "json")  {


}



?>