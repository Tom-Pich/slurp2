<?php

namespace App\Controller;

class Error404Controller
{

	public function show($page_type="not found"){
		$page = [
			"title" => "Oups&hellip; Erreur 404&nbsp;!",
			"description" => "La ressource demandée n’existe pas",
			"body-class" => "not-found",
		];
		http_response_code(404);
		include "content/components/header.php";
		include "content/pages/zz-not-found.php";
		include "content/components/footer.php";
	}
}