<?php

namespace App\Controller;

use JDS\Controller\AbstractController;
use JDS\Http\Response;

class PostsController extends AbstractController
{
	// making a form you have a 'create' method
	// to store the data from a form you have a method called 'store'


	public function show(int $id) : Response
	{
		return $this->render('post.html.twig', [
			'postId' => $id
		]);

		// $content = "This is post {$id}";
		// return new Response($content);
	}

	public function create() : Response
	{
		return $this->render('create-post.html.twig');
	}
}

