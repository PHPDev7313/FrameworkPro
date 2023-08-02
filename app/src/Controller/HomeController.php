<?php

namespace App\Controller;

use App\Widget;
use JDS\Controller\AbstractController;

use JDS\Http\Response;

class HomeController extends AbstractController
{

	public function __construct(private Widget $widget)
	{
	}



	public function index(): Response
	{
		// dd($this->container->get('twig'));
		$content = "<h1>Hello World You have reached the Home page</h1><br>Widge: {$this->widget->name}";
		return new Response($content);
	}
}
