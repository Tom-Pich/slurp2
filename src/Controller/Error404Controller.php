<?php

namespace App\Controller;

class Error404Controller extends PageController
{
	public function __construct()
	{
		$page_data = [
			"name" => "404-error",
			"title" => "Oups… Erreur 404 !",
			"body-class" => "basic-page",
			"file" => "zz-not-found",
		];

		parent::__construct($page_data);
	}

	public function show($payload = NULL){
		
		http_response_code(404);
		parent::show($payload);
	}
}