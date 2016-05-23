<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'sonic1988',
        'dbname'   => 'dinhdalat',
        'charset'  => 'utf8',
    ),
    'application' => array(
        'modelsDir'      => __DIR__ . '/../models/',
        'migrationsDir'  => __DIR__ . '/../migrations/',
        'baseUri'        => '/webdinhdalat/'
    )
));