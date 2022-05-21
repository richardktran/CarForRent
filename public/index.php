<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

use Khoatran\CarForRent\App\Application;
use Khoatran\CarForRent\App\RouteManage;

error_reporting(E_ALL);
ini_set('display_errors', '1');

RouteManage::run();
$app = new Application();
$app->run();
