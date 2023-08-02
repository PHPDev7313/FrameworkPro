<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

$container = require BASE_PATH . '/config/services.php';

use JDS\Kernel;
use JDS\Http\Request;

$request = Request::createFromGlobals();

// kernel represents the core of the application
$kernel = $container->get(Kernel::class);

$response = $kernel->handle($request);

$response->send();

