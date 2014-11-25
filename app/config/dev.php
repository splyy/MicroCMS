<?php

// include the prod configuration
require __DIR__.'/prod.php';

// enable the debug mode
$app['debug'] = true;

// override log level
$app['monolog.level'] = 'INFO';
