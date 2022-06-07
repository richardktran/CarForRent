<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

use Khoatran\CarForRent\App\Application;
use Khoatran\CarForRent\App\RouteManage;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Service\ServiceProvider;


RouteManage::run();
$app = new Application();

$app->run();
