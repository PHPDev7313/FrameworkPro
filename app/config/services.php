<?php

use JDS\Kernel;
use JDS\Routing\Router;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Container;
use JDS\Routing\RouterInterface;
use League\Container\ReflectionContainer;

$container = new Container();

$container->delegate(new ReflectionContainer(true));

# parameters for application config
$routes = include BASE_PATH . '/routes/web.php';

# services

/** when I ask for routerinterface send me back the router (alias) */
$container->add(
	RouterInterface::class,
	Router::class
);

$container->extend(RouterInterface::class)
	->addMethodCall(
		'setRoutes',
		[new ArrayArgument($routes)]
	);

/** load the kernel and all its dependencies */
$container->add(Kernel::class)
	->addArgument(RouterInterface::class)
	->addArgument($container)
	;

return $container;
