<?php

namespace App\Controller;

use App\Widget;
use JDS\Controller\AbstractController;
use Twig\Environment;
use JDS\Http\Response;

class HomeController extends AbstractController
{

	public function __construct(private Widget $widget)
	{
	}



	public function index(): Response
	{
	// 	$this->container->get('twig')->render();
	// 	$content = "<h1>Hello World You have reached the Home page</h1><br>Widge: {$this->widget->name}";
	// 	return new Response($content);
		return $this->render('home.html.twig');
	}
}
