<?php

require_once 'config.php';
require_once '../vendor/autoload.php';

use KCTAPI\Controllers\UserController;
use Slim\Slim;

$app = new Slim(array(
            'mode' => $config['mode'],
            'log.enabled' => true,
            'log.level' => \Slim\Log::DEBUG
        ));

$env = $app->environment;
$env['slim.errors'] = fopen(LOG_FILE, 'a');

$userController = new UserController();
$userController->installPaths();

$userController = new CustomerController();
$userController->installPaths();

$app->config('debug', true);
$app->run();

fclose($env['slim.errors']);
