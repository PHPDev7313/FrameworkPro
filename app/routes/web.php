<?php 
// [Get method, URI, [Controller, Method, title]]
return [
	['GET', '/', [\App\Controller\HomeController::class, 'index']],
	['GET', '/posts/{id:\d+}', [\App\Controller\PostsController::class, 'show']],
	['GET', '/hello/{name:.+}', function(string $name) {
		return new \JDS\Http\Response("Hello $name");
	}]
];



			
