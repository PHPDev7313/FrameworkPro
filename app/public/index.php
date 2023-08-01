<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';
use JDS\Kernel;
use JDS\Http\Request;
use JDS\Routing\Router;



$request = Request::createFromGlobals();

$router = new Router();

// kernel represents the core of the application
$kernel = new Kernel($router);

$response = $kernel->handle($request);

$response->send();

