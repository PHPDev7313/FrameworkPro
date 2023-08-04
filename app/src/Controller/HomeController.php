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
		return $this->render('home.html.twig');
	}
}
