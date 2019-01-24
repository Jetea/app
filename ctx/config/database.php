<?php
return [
    'default' => array(
        'master' => [  //默认数据库
            'driver'    => 'mysql',
            'host'      => 'mysql',
            'port'      => 3306,
            'database'  => 'es_demo',
            'username'  => 'root',
            'password'  => '123123',
            'charset'   => 'utf8mb4',
        ],
        'slave' => [
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'port'      => 3306,
            'database'  => 'es_demo',
            'username'  => 'root',
            'password'  => '123123',
            'charset'   => 'utf8mb4',
        ]
    ),
    // 'MDB_MISSION'
    'user' => [
        'master' => [  //默认数据库
            'driver'    => 'pgsql',
            'host'      => 'postgres',
            'port'      => 5432,
            'database'  => 'es_demo',
            'username'  => 'postgres',
            'password'  => '123123',
        ],
        'slave' => [
            'driver'    => 'pgsql',
            'host'      => '127.0.0.1',
            'port'      => 5432,
            'database'  => 'postgres',
            'username'  => 'forge',
            'password'  => '',
        ]
    ],
];
