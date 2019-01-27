<?php
return [
    [
        "name" => "admin",
        "prefix" => "",
        "domain" => env('http_route_admin',""),
        "middleware" => ['adminlogin','adminaccess', 'adminglob'],
        "routes" => [
            //$method,$path,$uses,$middleware
            ['get', '/', "admin::index/index"],
            ['get', '/msg', "admin::index/msg"],
            ['any', '/login', 'admin::account/login'],
            ['any', '/logout', 'admin::account/logout'],
            //权限管理
            ['get', '/access/access_view', 'admin::base@access@access/view'],
            ['get', '/access/role_index', 'admin::base@access@role/index'],
            ['get', '/access/role_add', 'admin::base@access@role/add'],
            ['post', '/access/role_doadd', 'admin::base@access@role/doadd'],
            ['get', '/access/role_edit/<id:\w+>', 'admin::base@access@role/edit'],
            ['post', '/access/role_doedit', 'admin::base@access@role/doedit'],
            ['get', '/access/role_delete/<id:\w+>', 'admin::base@access@role/delete'],
            ['get', '/access/role_accessmg/<id:\w+>', 'admin::base@access@role/accessMg'],
            ['post', '/access/role_accesssave/<id:\w+>', 'admin::base@access@role/accessSave'],
            //汇报关系
            ['get', '/access/reportr', 'admin::base@access@reportr/index'],
            ['post', '/access/update_reportr', 'admin::base@access@reportr/doEdit'],
            //用户管理
            ['get', '/user', 'admin::base@user@index/index'],
            ['get', '/user/add', 'admin::base@user@index/add'],
            ['post', '/user/doadd', 'admin::base@user@index/doadd'],
            ['get', '/user/edit/<id:\w+>', 'admin::base@user@index/edit'],
            ['post', '/user/doedit/<id:\w+>', 'admin::base@user@index/doedit'],
            ['post', '/user/doeditpwd/<id:\w+>', 'admin::base@user@index/doeditpwd'],
            ['get', '/user/editpwd/<id:\w+>', 'admin::base@user@index/editpwd'],
            ['get', '/user/lock/<id:\w+>', 'admin::base@user@index/lock'],
            ['get', '/user/setting', 'admin::base@user@index/setting'],
            ['post', '/user/crop', 'admin::base@user@index/crop'],
            ['post', '/user/modifiPwd', 'admin::base@user@index/modifiPwd'],
            //数据管理
            ['get', '/data/map_index', 'admin::base@data@map/index'],
            ['get', '/data/map_add', 'admin::base@data@map/add'],
            ['get', '/data/map_delete/<id:\w+>', 'admin::base@data@map/del'],
            ['post', '/data/map_doadd', 'admin::base@data@map/doadd'],
            ['get', '/data/map_edit/<id:\w+>', 'admin::base@data@map/edit'],
            ['post', '/data/map_doedit/<id:\w+>', 'admin::base@data@map/doedit'],
            ['get', '/data/map_addoption/<groupid:\w+>', 'admin::base@data@map/addoption'],
            ['post', '/data/map_doaddoption/<groupid:\w+>', 'admin::base@data@map/doaddoption'],
            ['post', '/data/map_updateoption', 'admin::base@data@map/updateoption'],
            ['get', '/data/map_deloption/<id:\w+>', 'admin::base@data@map/deloption'],
            //文件上传管理
            ['get', '/data/attachment_index/<code=default:\w+>', 'admin::base@data@attachment/index'],
            ['get', '/data/attachment_addgroup', 'admin::base@data@attachment/addgroup'],
            ['post', '/data/attachment_doaddgroup', 'admin::base@data@attachment/doaddgroup'],
            ['get', '/data/attachment_deletegroup/<code:\w+>', 'admin::base@data@attachment/deletegroup'],
            ['get', '/data/attachment_deletefile/<id:\w+>', 'admin::base@data@attachment/deletefile'],
            ['get', '/data/attachment_showbind/<id:\w+>', 'admin::base@data@attachment/showbind'],
            //日志查看
            ['get', '/data/syslog_index', 'admin::base@data@syslog/index'],
            //数据备份
            ['get', '/data/backup_index', 'admin::base@data@backup/index'],
            ['post', '/data/backup_backup', 'admin::base@data@backup/backup'],
            ['get', '/data/backup_restore', 'admin::base@data@backup/restore'],
            ['get', '/data/backup_dorestore/<id:\w+>', 'admin::base@data@backup/doRestore'],
            ['get', '/data/backup_upyun/<id:\w+>', 'admin::base@data@backup/upyun'],
            //缓存管理
            ['get', '/data/cache_clear', 'admin::base@data@cache/clear'],
            ['get', '/data/cache_doclear', 'admin::base@data@cache/doClear'],
            ['get', '/data/cache_dofileclear', 'admin::base@data@cache/doFileClear'],
            ['get', '/data/cache_doCompileClear', 'admin::base@data@cache/doCompileClear'],
        ]
    ]
];


