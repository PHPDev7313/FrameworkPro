<?php 
// [Get method, URI, [Controller, Method, title]]
return [
	['GET', '/', [\App\Controller\HomeController::class, 'index']],
	['GET', '/posts/{id:\d+}', [\App\Controller\PostsController::class, 'show']]
];



			// $routeCollector->addRoute('GET', '/posts/{id:\d+}', function ($routeParams) {
			// 	$content = "<h1>This is Post {$routeParams['id']}</h1>";

			// 	return new Response($content);
			// });

			// // this will allow [a-zA-Z0-9] no special characters
			// $routeCollector->addRoute('GET', '/user/{userid:\w+}', function ($routeParams) {
			// 	$content = "<h1>This is Post {$routeParams['userid']}</h1>";

			// 	return new Response($content);
			// });
