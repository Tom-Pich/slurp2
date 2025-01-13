<?php

namespace App\Controller;


class PageController
{
	private array $page;

	public function __construct(array $page_data)
	{
		$this->page = $page_data;
		$this->page["title"] = $page_data["title"] ?? "No title";
		$this->page["description"] = $page_data["description"] ?? "No description";
		$this->page["file"] = $page_data["file"] ?? "zz-not-found";
		$this->page["body-class"] = $page_data["body-class"] ?? "standard-page";
		$this->page["version"] = $page_data["version"] ?? 3;
		$this->page["aside-left"] = $this->page["aside-left"] ?? false;
		$this->page["aside-right"] = $this->page["aside-right"] ?? false;
	}

	public function show()
	{
		$page = $this->page;
		//echo "<pre>";  var_dump($page); die();
		if ($page["version"] === 4) {
			include "content/components-v4/header.php";

			echo "<main>";

			echo "<aside class='left'>";
			if ($page["aside-left"]) include "content/components/" . $page["aside-left"] . ".php";
			echo "</aside>";

			echo "<div id='page-content'>";
			include "content/pages/" . $page["file"] . ".php";
			echo "</div>";

			echo "<aside class='right'>";
			if ($page["aside-right"]) include "content/components/" . $page["aside-right"] . ".php";
			echo "</aside>";

			echo "</main>";

			include "content/components-v4/footer.php";
		} else {
			include "content/components/header.php";
			include "content/pages/" . $page["file"] . ".php";
			include "content/components/footer.php";
		}
	}
}
