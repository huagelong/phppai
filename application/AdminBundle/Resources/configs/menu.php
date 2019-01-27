<?php
return [
    "menu" => [
        'other'=>'常用',
        "system" => "系统",
    ],
    "other" => [
        ['admin::index/index', '首页','fa fa-desktop']
    ],
    "system"=>[
        ["-", "权限", "fa fa-group"],
        ["admin::base@access@access/view", "权限查看", "fa fa-lock"],
        ["admin::base@access@role/index", "角色管理", "fa fa-user"],
        ["admin::base@access@reportr/index", "汇报关系管理", "fa  fa-user-md"],
        ["admin::base@user@index/index", "用户管理","fa fa-group "],
        ["-", "设置", "fa fa-cogs"],
        ["admin::base@data@map/index", "字典管理", 'fa  fa-book'],
        ["admin::base@data@attachment/index", "文件管理",  'fa  fa-file-o'],
        ["admin::base@data@syslog/index", "系统日志",  'fa  fa-list-alt'],
        ["admin::base@data@backup/index", "数据库管理",  'fa  fa-database'],
        ["admin::base@data@cache/clear", "缓存管理",  'fa fa-copy'],
        ["admin::base@user@index/setting", "个人设置","fa fa-group "],
    ]
];



