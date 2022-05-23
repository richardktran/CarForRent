<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

use Khoatran\CarForRent\App\Application;
use Khoatran\CarForRent\App\RouteManage;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use Khoatran\CarForRent\Service\ServiceProvider;

error_reporting(E_ALL);
ini_set('display_errors', '1');

RouteManage::run();
$app = new Application();
$request = new Request();
$responseView = new Response();
$provider = new ServiceProvider();
$app->run($request, $responseView, $provider);
