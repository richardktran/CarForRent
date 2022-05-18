<?php

require __DIR__ . '/../vendor/autoload.php';

use Khoatran\CarForRent\Application;
use Khoatran\CarForRent\Controller\LoginController;

error_reporting(E_ALL);
ini_set('display_errors', '1');
include '../src/routes.php';
$app = new Application();

$app->run();
