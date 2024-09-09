<?php
/*
* 基础架构: 单点低代码开发平台
* 版权所有: 郑州单点科技软件有限公司
* Email: moodle360@qq.com
* Copyright (c) 2023
* License: GPL V3 or Commercial license
*/
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
header("Content-Type: application/json");
require_once('../cors.php');
require_once('../include.inc.php');
ini_set('max_execution_time', 7200);

//限制从本地IP访问.
$AllowAccessIpList = ['127.0.0.1', '::1'];
if (!in_array($_SERVER['REMOTE_ADDR'], $AllowAccessIpList)) {
    header('HTTP/1.0 403 Forbidden');
    echo 'Access forbidden';
    exit();
}






?>