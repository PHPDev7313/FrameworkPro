<?php

namespace App\Controller;

use JDS\Controller\AbstractController;
use JDS\Http\Response;

class PostsController extends AbstractController
{

	public function show(int $id) : Response
	{
		return $this->render('posts.html.twig', [
			'postId' => $id
		]);

		// $content = "This is post {$id}";
		// return new Response($content);
	}
}