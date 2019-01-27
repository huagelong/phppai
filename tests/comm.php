<?php
/**
 * Created by PhpStorm.
 * User: wangkaihui
 * Date: 2018/12/6
 * Time: 13:21
 */
$matches = [];
preg_match("#^(.*)\\.tag2\\.test$#si", "www.tag2.test", $matches);
print_r($matches);
