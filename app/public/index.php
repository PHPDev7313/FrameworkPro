<?php

declare(strict_types=1);
use JDS\Kernel;
use JDS\Http\Request;

define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/vendor/autoload.php';

$container = require BASE_PATH . '/config/services.php';

$request = Request::createFromGlobals();

// kernel represents the core of the application
$kernel = $container->get(Kernel::class);

$response = $kernel->handle($request);

$response->send();

// /var/www/html/public/css
// /var/www/html/public/js/vendor
