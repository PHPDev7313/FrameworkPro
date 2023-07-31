<?php

namespace App\Controller;
use JDS\Http\Response;

class PostsController
{

	public function show(int $id) : Response
	{
		$content = "This is post {$id}";
		return new Response($content);
	}
}