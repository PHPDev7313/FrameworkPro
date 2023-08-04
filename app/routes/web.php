<?php 
// [Get method, URI, [Controller, Method, title]]
return [
	['GET', '/', [\App\Controller\HomeController::class, 'index']],
	['GET', '/posts/{id:\d+}', [\App\Controller\PostsController::class, 'show']],
	['GET', '/posts', [\App\Controller\PostsController::class, 'create']],
	['GET', '/hello/{name:.+}', function(string $name) {
		return new \JDS\Http\Response("Hello $name");
	}]
];

// making a form you have a 'create' method
// to store the data from a form you have a method called 'store'




			
