<?php
declare(strict_types=1);

use JDS\Kernel;
use JDS\Http\Request;


require_once dirname(__DIR__) . '/vendor/autoload.php';

// ***** request received *****
$request = Request::createFromGlobals();

// ***** perform some logic *****

// ***** send response (string of content) *****


// kernel represents the core of the application
$kernel = new Kernel();

$response = $kernel->handle($request);

$response->send();

