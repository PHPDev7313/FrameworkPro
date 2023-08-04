<?php
use JDS\Controller\AbstractController;

$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->load(BASE_PATH . '/.env');

$container = new League\Container\Container();

$container->delegate(new League\Container\ReflectionContainer(true));

# parameters for application config
$routes = include BASE_PATH . '/routes/web.php';
$templatesPath = BASE_PATH . '/templates';
$cssPath = BASE_PATH . '/public/css';
$jsPath = BASE_PATH . '/public/js';

$container->add(
	'APP_ENV', 
	new League\Container\Argument\Literal\StringArgument($_SERVER['APP_ENV'])
);
$databaseUrl = 'sqlite:///' . BASE_PATH . '/var/db.sqlite';
// can I do this same thing with the css and js from the public folder?
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

$container->add(JDS\Controller\AbstractController::class);

// using inflectors
// https://container.thephpleague.com
// pass the container into the abstract class which will
// allow is to use twig through the container
$container->inflector(\App\Controller\HomeController::class)
	->invokeMethod('setContainer', [$container]);

$container->inflector(App\Controller\PostsController::class)
	->invokeMethod('setContainer', [$container]);

$container->add(\JDS\Dbal\ConnectionFactory::class)
	->addArgument([new \League\Container\Argument\Literal\StringArgument($databaseUrl)
	]);

$container->addShared(\Doctrine\DBAL\Connection::class, function() use ($container): \Doctrine\DBAL\Connection {
	return $container->get(\JDS\Dbal\ConnectionFactory::class)->create();
});

return $container;



