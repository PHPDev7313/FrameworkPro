<?php

namespace JDS;

use JDS\Http\Request;
use JDS\Http\Response;

/**
 * Core of the application
 * 
 * its primary responsibility is to
 * receive a request and output a response
 * 
 * @package JDS
 */
class Kernel
{

	public function handle(Request $request) : Response {
		$content = '<h1>This is from the Kernel</h1>';
		return new Response($content);
	}
}