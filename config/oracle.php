<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('ORACLE_DB_TNS', ''),
        'host'           => env('ORACLE_DB_HOST', ''),
        'port'           => env('ORACLE_DB_PORT', '1521'),
        'database'       => env('ORACLE_DB_DATABASE', ''),
        'service_name'   => env('ORACLE_DB_SERVICENAME', ''),
        'username'       => env('ORACLE_DB_USERNAME', ''),
        'password'       => env('ORACLE_DB_PASSWORD', ''),
        'charset'        => env('ORACLE_DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('ORACLE_DB_PREFIX', ''),
        'prefix_schema'  => env('ORACLE_DB_SCHEMA_PREFIX', ''),
        'server_version' => env('ORACLE_DB_SERVER_VERSION', '11g'),
        'load_balance'   => env('ORACLE_DB_LOAD_BALANCE', 'yes'),
        'max_name_len'   => env('ORACLE_ORA_MAX_NAME_LEN', 30),
        'dynamic'        => [],
    ],
];
