<?php
return [
    "httpd"=>[
        "host" => env("swoole_httpd_host","127.0.0.1"),
        "port" => env("swoole_httpd_port","8888"),
        "log_file" => STORAGE_PATH . "/log",
        "task_fail_log" => STORAGE_PATH . "/log/task_fail_log",
        "pfile"=>STORAGE_PATH."/httpd.pid",
        "task_retry_count" => env("swoole_httpd_task_retry_count",2),
        "task_timeout" => env("swoole_httpd_task_timeout", 1),
        "max_request"=> env("swoole_httpd_max_request", 1),
        "task_max_request"=>env("swoole_httpd_task_max_request", 500),
        "serialization" =>env("swoole_httpd_serialization", 1),
        "gzip" => env("swoole_httpd_gzip", 4),
        //设置为CPU的1-4倍最合理
        'worker_num' => env("swoole_httpd_worker_num", 8),
        "dispatch_mode" => env("swoole_httpd_dispatch_mode", 3),
        //一般设置为CPU核数的1-4倍，在swoole中reactor_num最大不得超过CPU核数*4。
        'reactor_num' => env("swoole_httpd_reactor_num", 8),
        "task_worker_num" => env("swoole_httpd_task_worker_num", 10),//task worker 数量
        'heartbeat_check_interval' => env("swoole_httpd_heartbeat_check_interval", 10),
        'heartbeat_idle_time' => env("swoole_httpd_heartbeat_idle_time", 60),
        //单次发送缓存区
        "buffer_output_size"=>env("swoole_httpd_buffer_output_size", 32 * 1024 *1024),
        //静态文件
        "static_expire_time"=>env("swoole_httpd_static_expire_time", 86400),
        "static_path"=>[
            "^\/static" => ROOT_PATH . '/public/static',
        ]
    ],
    "jobd"=>[
        "host" => env("swoole_jobd_host", "127.0.0.1"),
        "port" => env("swoole_jobd_port", "8889"),
        "log_file" => STORAGE_PATH . "/logjobd",
        "task_fail_log" => STORAGE_PATH . "/logjobd_fail_log",
        "pfile"=>STORAGE_PATH."/jobd.pid",
        "task_retry_count" => env("swoole_jobd_task_retry_count", 2),
        "task_timeout" => env("swoole_jobd_task_timeout", 1),
        "max_request"=>env("swoole_jobd_max_request", 500),
        "task_max_request"=>env("swoole_jobd_task_max_request", 500),
        "serialization" => env("swoole_jobd_serialization", 1),
        //设置为CPU的1-4倍最合理
        "dispatch_mode" => env("swoole_jobd_dispatch_mode", 4),
        //一般设置为CPU核数的1-4倍，在swoole中reactor_num最大不得超过CPU核数*4。
        'reactor_num' => env("swoole_jobd_reactor_num", 8),
        "task_worker_num" => env("swoole_jobd_task_worker_num", 4),//task worker 数量
        'heartbeat_check_interval' => env("swoole_jobd_heartbeat_check_interval", 10),
        'heartbeat_idle_time' => env("swoole_jobd_heartbeat_idle_time", 60),
        //单次发送缓存区
        "buffer_output_size"=>env("swoole_jobd_buffer_output_size", 32 * 1024 *1024)
    ],
];