<?php

$config = array();
$mode = 'development';
//$mode = 'production';

$config['development']['dbName'] = 'kct-dev';
$config['development']['dbUser'] = 'postgres';
$config['development']['dbPassword'] = 'toor';
$config['development']['dbHost'] = 'localhost';

$config['production']['dbName'] = 'kct-prod';
$config['production']['dbUser'] = 'postgres';
$config['production']['dbPassword'] = 'toor';
$config['production']['dbHost'] = 'localhost';

$config['log_file'] = 'logs/logs.txt';
$config['vendor'] = '../vendor/';
$config['mode'] = $mode;
$config['development']['base_url']='http://localhost/kct-dev/api/index.php';

define('LOG_FILE', $config['log_file']);

if($mode !== 'production'){
    error_reporting(E_ALL);
}
