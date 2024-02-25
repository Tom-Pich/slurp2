<?php

namespace App\Controller;
		

class PageController
{
	private array $page;

	public function __construct(array $page_data)
	{
		$this->page = $page_data;
		$this->page["title"] = $page_data["title"] ?? "No title" ;
		$this->page["description"] = $page_data["description"] ?? "No description";
		$this->page["file"] = $page_data["file"] ?? "zz-not-found";
		$this->page["body-class"] = $page_data["body-class"] ?? "standard-page";
	}

	public function show($page_type="page")
	{
		$page = $this->page;
		include "content/components/header.php";
		if ($page_type === "scenario"){
			include "content/components/scenario-template.php";			
		} else {
			include "content/pages/" . $this->page["file"] . ".php";
		}
		include "content/components/footer.php";
	}
}
