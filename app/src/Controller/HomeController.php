<?php

namespace App\Controller;

use JDS\Http\Response;

class HomeController 
{

	public function index() : Response
	{
		$content = "<h1>Hello World You have reached the Home page</h1>";
		return new Response($content);
	}
}