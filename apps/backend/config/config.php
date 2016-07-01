<?php
defined('APP_PATH') || define('APP_PATH', realpath('.'));

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname'   => 'dinhdalat',
        'charset'  => 'utf8',
    ),
    'application' => array(
        'controllersDir' => '../apps/backend/controllers/',
        'modelsDir'      => '../apps/backend/models/',
        'migrationsDir'  => '../apps/backend/migrations/',
        'viewsDir'       => '../apps/backend/views/',
        'baseUri'        => ''
    )
));