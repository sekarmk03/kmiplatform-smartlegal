<?php
return [
    'driver' => 'mysql',
    'url' => '',
    'host' => 'localhost',
    'port' => '3306',
    'database' => 'database',
    'username' => 'root',
    'password' => '',
    'unix_socket' => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded( 'pdo_mysql' ) ?
        array_filter( [ PDO::MYSQL_ATTR_SSL_CA => env( 'MYSQL_ATTR_SSL_CA' ), ] ) : [],
];