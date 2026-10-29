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

	public function show($payload = NULL)
	{

		http_response_code(404);
		// Évite qu'un navigateur ou proxy ne garde en cache la 404 (si la page est créée juste après)
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		// Directive explicite pour les moteurs de recherche
		header("X-Robots-Tag: noindex, nofollow", true);
		parent::show($payload);
	}
}
