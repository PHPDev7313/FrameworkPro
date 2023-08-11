<?php

namespace App\Controller;

use App\Widget;
use Twig\Environment;
use JDS\Http\Response;
use JDS\Controller\AbstractController;

class HomeController extends AbstractController
{

	public function __construct(private Widget $widget)
	{
	}



	public function index(): Response
	{
		return $this->render('home.html.twig', [$this->container->get('filesystem-loader')]);
	}
}
