<?php
define("ROOT_PATH", __DIR__."/..");
define("STORAGE_PATH", __DIR__."/../storage");
define("APPLICATION_PATH",__DIR__."/../application");
define("RESOURCE_PATH",__DIR__."/../resources");
require_once __DIR__ . "/../vendor/autoload.php";

$region = "cn-hangzhou";
$appKey = "LTAIp3wwAUS7PsaJ";
$appSecret = "q6xqgZ5J8YLMwv6iNOODyD8lgJuVMd";
$accountName = "service@mail.2tag.cn";
$accountAlias = "service";

$obj = new \Trensy\DirectMail\Mail($region, $appKey, $appSecret, $accountName, $accountAlias);
$obj->send("trensy@qq.com", "hello world1", "hello world2");