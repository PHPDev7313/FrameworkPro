<?php

use JDS\Kernel;
use JDS\Routing\Router;
use League\Container\Container;
use JDS\Routing\RouterInterface;
use Symfony\Component\Dotenv\Dotenv;
use League\Container\ReflectionContainer;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;

$dotenv = new Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

$container = new Container();

$container->delegate(new ReflectionContainer(true));

# parameters for application config
$routes = include BASE_PATH . '/routes/web.php';

$container->add(
	'APP_ENV', 
	new StringArgument($_SERVER['APP_ENV'])
);

# services

/** when I ask for RouterInterface (alias) send me back the Router  */
$container->add(
	RouterInterface::class,
	Router::class
);

// after instantiation we can add to the object 
$container->extend(RouterInterface::class)
	// add the routes to the router through the RouterInterface alias
	->addMethodCall(
		'setRoutes',
		[new ArrayArgument($routes)]
	);

/** load the kernel and all its dependencies */
$container->add(Kernel::class)
	// pass the routes into the Kernel 
	->addArgument(RouterInterface::class)
	// setup auto wiring (ability to instantiate all dependent classes)
	->addArgument($container)
	;

return $container;
