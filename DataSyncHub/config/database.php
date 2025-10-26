<?php

use Illuminate\Support\Str;

return [

    'default' => env('DB_CONNECTION', 'pgsql'),

    'connections' => [

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DB_PGSQL_URL'),
            'host' => env('DB_PGSQL_HOST', '127.0.0.1'),
            'port' => env('DB_PGSQL_PORT', '5432'),
            'database' => env('DB_PGSQL_DATABASE', 'forge'),
            'username' => env('DB_PGSQL_USERNAME', 'forge'),
            'password' => env('DB_PGSQL_PASSWORD', ''),
            'charset' => env('DB_PGSQL_CHARSET', 'utf8'),
            'prefix' => env('DB_PGSQL_PREFIX', ''),
            'prefix_indexes' => true,
            'search_path' => env('DB_PGSQL_SCHEMA', 'public'),
            'sslmode' => 'prefer',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DB_MYSQL_URL'),
            'host' => env('DB_MYSQL_HOST', '127.0.0.1'),
            'port' => env('DB_MYSQL_PORT', '3306'),
            'database' => env('DB_MYSQL_DATABASE', 'forge'),
            'username' => env('DB_MYSQL_USERNAME', 'forge'),
            'password' => env('DB_MYSQL_PASSWORD', ''),
            'unix_socket' => env('DB_MYSQL_SOCKET', ''),
            'charset' => env('DB_MYSQL_CHARSET', 'utf8mb4'),
            'collation' => env('DB_MYSQL_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => env('DB_MYSQL_PREFIX', ''),
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mongodb' => [
            'driver' => 'mongodb',
            'host' => env('DB_MONGODB_HOST', '127.0.0.1'),
            'port' => env('DB_MONGODB_PORT', 27017),
            'database' => env('DB_MONGODB_DATABASE', 'forge'),
            'username' => env('DB_MONGODB_USERNAME', ''),
            'password' => env('DB_MONGODB_PASSWORD', ''),
            'options' => [
                'appname' => 'datasynchub',
                'authSource' => 'admin',
            ],
        ],

    ],

    'migrations' => [
        'table' => 'migrations',
        'connection' => null,
    ],

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
