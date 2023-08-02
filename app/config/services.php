<?php

$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->load(BASE_PATH . '/.env');

$container = new League\Container\Container();

$container->delegate(new League\Container\ReflectionContainer(true));

# parameters for application config
$routes = include BASE_PATH . '/routes/web.php';
$templatesPath = BASE_PATH . '/templates';

$container->add(
	'APP_ENV', 
	new League\Container\Argument\Literal\StringArgument($_SERVER['APP_ENV'])
);

# services

/** when I ask for RouterInterface (alias) send me back the Router  */
$container->add(
	JDS\Routing\RouterInterface::class,
	JDS\Routing\Router::class
);

// after instantiation we can add to the object 
$container->extend(JDS\Routing\RouterInterface::class)
	// add the routes to the router through the RouterInterface alias
	->addMethodCall(
		'setRoutes',
		[new League\Container\Argument\Literal\ArrayArgument($routes)]
	);

/** load the kernel and all its dependencies */
$container->add(JDS\Kernel::class)
	// pass the routes into the Kernel 
	->addArgument(JDS\Routing\RouterInterface::class)
	// setup auto wiring (ability to instantiate all dependent classes)
	->addArgument($container)
;

// load up twig with the templatesPath where all the templates will be stored
$container->addShared('filesystem-loader', Twig\Loader\FilesystemLoader::class)
	->addArgument(new League\Container\Argument\Literal\StringArgument($templatesPath));

// set the alias 'twig' to point to the Environment class of twig
$container->addShared('twig', Twig\Environment::class)
	->addArgument('filesystem-loader');

// using inflectors
// https://container.thephpleague.com
$container->add(JDS\Controller\AbstractController::class);

// pass the container into the abstract class which will
// allow is to use twig through the container
$container->inflector(App\Controller\AbstractController::class)
	->invokeMethod('setContainer', [$container])
;

return $container;



