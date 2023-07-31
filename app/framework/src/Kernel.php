<?php

namespace JDS;

use FastRoute\RouteCollector;
use JDS\Http\Request;
use JDS\Http\Response;

/**
 * Core of the application
 * 
 * its primary responsibility is to
 * receive a request and output a response
 * 
 * @package JDS
 */
class Kernel
{

	/**
	 * handle the requests
	 * 
	 * @param Request $request 
	 * @return Response 
	 */
	public function handle(Request $request) : Response {

		// ***** Create a dispatcher *****
		$dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $routeCollector) {
			$routeCollector->addRoute('GET', '/', function () {
				$content = '<h1>This is from the Kernel</h1>';

				return new Response($content);

			});

			$routeCollector->addRoute('GET', '/posts/{id:\d+}', function ($routeParams) {
				$content = "<h1>This is Post {$routeParams['id']}</h1>";

				return new Response($content);
			});
			// this will allow [a-zA-Z0-9] no special characters
			$routeCollector->addRoute('GET', '/user/{userid:\w+}', function ($routeParams) {
				$content = "<h1>This is Post {$routeParams['userid']}</h1>";

				return new Response($content);
			});

		});

		// ***** Dispatch a URI, to obtain the route info *****
			// three things we want back, Status, Handler and any variables
			// dispatch requires 2 pieces of information
				// 1. httpMethod
				// 2. uri
				// both can be found in the request

		$routeInfo = $dispatcher->dispatch(
			$request->getMethod(),
			$request->getPathInfo()
		);

		[$status, $handler, $vars] = $routeInfo;


		
		// ***** Call the handler, provided by the route info, in order to create a Response *****
		return $handler($vars);

	}
}