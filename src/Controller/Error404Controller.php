<?php

namespace App\Controller;

class Error404Controller
{

	public function show(){
		$page = [
			"title" => "Oups&hellip; Erreur 404&nbsp;!",
			"description" => "La ressource demandée n’existe pas",
			"body-class" => "basic-page",
			"file" => "zz-not-found",
			"version" => 4,
		];
		$page_controller = new PageController($page);
		http_response_code(404);
		$page_controller->show();
	}
}