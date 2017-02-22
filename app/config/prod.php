<?php

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'charset'  => 'utf8',
    'host'     => '127.0.0.1',
    'port'     => '3306',
    'dbname'   => 'microcms',
    'user'     => 'microcms_user',
    'password' => 'secret',
);

// define log parameters
$app['monolog.logfile'] = __DIR__.'/../../var/logs/silex.log';
$app['monolog.level'] = 'WARNING';
