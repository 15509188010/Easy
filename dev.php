<?php
return [
    'SERVER_NAME' => "EasySwoole",
    'MAIN_SERVER' => [
        'LISTEN_ADDRESS' => '0.0.0.0',
        'PORT'           => 9501,
        'SERVER_TYPE'    => EASYSWOOLE_WEB_SERVER, //可选为 EASYSWOOLE_SERVER  EASYSWOOLE_WEB_SERVER EASYSWOOLE_WEB_SOCKET_SERVER,EASYSWOOLE_REDIS_SERVER
        'SOCK_TYPE'      => SWOOLE_TCP,
        'RUN_MODEL'      => SWOOLE_PROCESS,
        'SETTING'        => [
            'worker_num'    => 8,
            'reload_async'  => true,
            'max_wait_time' => 3
        ],
        'TASK'           => [
            'workerNum'     => 4,
            'maxRunningNum' => 128,
            'timeout'       => 15
        ]
    ],
    'TEMP_DIR'    => '/logs/Temp',
    'LOG_DIR'     => 'logs/Log',

    /**************mysql****************/
    'MYSQL'       => [
        'host'              => '127.0.0.1',
        'port'              => 3300,
        'user'              => 'root',
        'password'          => '123456',
        'database'          => 'test',
        'timeout'           => 5,
        'charset'           => 'utf8mb4',
        'maxIdleTime'       => 15,
        'intervalCheckTime' => 30 * 1000,
        'getObjectTimeout'  => 3,
        'maxObjectNum'      => 20,
        'minObjectNum'      => 5,
    ]
];
