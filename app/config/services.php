<?php

use JDS\Console\Application;
use Doctrine\DBAL\Connection;
use JDS\Dbal\ConnectionFactory;
use JDS\Controller\AbstractController;
use JDS\Console\Command\MigrateDatabase;
use League\Container\Argument\Literal\StringArgument;

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(BASE_PATH . '/.env');

$container = new \League\Container\Container();

$container->delegate(new \League\Container\ReflectionContainer(true));

# parameters for application config
$routes = include BASE_PATH . '/routes/web.php';

$templatesPath = BASE_PATH . '/templates';

$container->add(
	'APP_ENV', 
	new StringArgument($_SERVER['APP_ENV'])
);
$databaseUrl = 'sqlite:///' . BASE_PATH . '/var/db.sqlite';
//pdo-mysql://localhost:3306/framework-pro?charset=utf8mb4

$container->add(
	'base-commands-namespace',
	new StringArgument('JDS\\Console\\Command\\')
);

// can I do this same thing with the css and js from the public folder?
# services

/** when I ask for RouterInterface (alias) send me back the Router  */
$container->add(
	\JDS\Routing\RouterInterface::class,
	\JDS\Routing\Router::class
);

// after instantiation we can add to the object 
$container->extend(\JDS\Routing\RouterInterface::class)
	// add the routes to the router through the RouterInterface alias
	->addMethodCall(
		'setRoutes',
		[new \League\Container\Argument\Literal\ArrayArgument($routes)]
	);

/** load the Core kernel and all its dependencies */
$container->add(\JDS\Kernel::class)
	// pass the routes into the Kernel 
	->addArgument(\JDS\Routing\RouterInterface::class)
	// setup auto wiring (ability to instantiate all dependent classes)
	->addArgument($container);

/** load the Console Kernel  */
$container->add(\JDS\Console\Kernel::class)
	->addArguments([$container, Application::class]);

	/** add container to Application */
$container->add(Application::class)
	->addArgument($container);

// load up twig with the templatesPath where all the templates will be stored
$container->addShared('filesystem-loader', \Twig\Loader\FilesystemLoader::class)
	->addArgument(new StringArgument($templatesPath));



// set the alias 'twig' to point to the Environment class of twig
$container->addShared('twig', Twig\Environment::class)
	->addArgument('filesystem-loader');

$container->add(AbstractController::class);

// using inflectors
// https://container.thephpleague.com
// pass the container into the abstract class which will
// allow is to use twig through the container
$container->inflector(\App\Controller\HomeController::class)
	->invokeMethod('setContainer', [$container]);

$container->inflector(\App\Controller\PostsController::class)
	->invokeMethod('setContainer', [$container]);

$container->add(ConnectionFactory::class)
	->addArgument(new StringArgument($databaseUrl)
	);

$container->addShared(\Doctrine\DBAL\Connection::class, function() use ($container): \Doctrine\DBAL\Connection {
	return $container->get(ConnectionFactory::class)->create();
});

$container->add(
	'database:migrations:migrate',
	MigrateDatabase::class
)->addArguments([Connection::class, new StringArgument(BASE_PATH . '/migrations')]);

return $container;



