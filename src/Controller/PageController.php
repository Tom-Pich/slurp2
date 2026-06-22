<?php

namespace App\Controller;


class PageController
{
	// private array $page;
	public string $name;
	public string $title;
	public string $file;
	public string $description;		// default ""
	public string $bodyClass;		// default "standard
	public int $version;			// default 4
	public string $asideLeft;		// default ""
	public string $asideRight;		// default ""
	public int $accessRestriction;	// default 0

	public string $displayMode;		// default "auto"
	public string $displayStyle;	// default "normal"
	public string $displayTheme;	// default "standard"

	public string $canonical;

	public function __construct(array $page_data)
	{
		$this->name = $page_data["name"];
		$this->title = $page_data["title"];
		$this->file = "content/pages/" . $page_data["file"] . ".php";
		$this->description = $page_data["description"] ?? "";
		$this->bodyClass = $page_data["body-class"] ?? "standard-page";
		$this->version = $page_data["version"] ?? 4;
		$this->asideLeft = $page_data["aside-left"] ?? "";
		$this->asideRight = $page_data["aside-right"] ?? "";
		$this->accessRestriction = $page_data["access-restriction"] ?? 0;

		// user options
		$this->displayMode = $_SESSION["user-options"]["mode"] ?? "auto";
		$this->displayStyle = $_SESSION["user-options"]["style"] ?? "normal";
		$this->displayTheme = $_SESSION["user-options"]["theme"] ?? "standard";

		// processed page data
		$canonical_url = "/" . $this->name;
		if ($this->name === "home") $canonical_url = "";
		if (str_ends_with($this->name, "/home")) $canonical_url = "/" . substr($this->name, 0, -5);
		$this->canonical = "https://jdr.pichegru.net" . $canonical_url ;
	}

	public function show($payload = NULL)
	{
		$page = $this;

		// wiki page specification
		if ($page->file === "content/pages/wiki-page.php"){
			$article_references = explode( "/", $page->name);
			$wiki = $article_references[1];
			$article_name = $article_references[2];
			$page->file = "content/wikis/" . $wiki . "/" . $article_name . ".php";
		}

		include "content/components/header.php";

		echo "<div id='page-wrapper'>";

		echo "<aside class='left'>";
		if ($page->asideLeft) include "content/components/" . $page->asideLeft . ".php";
		echo "</aside>";

		echo "<main>";
		include $page->file;
		echo "</main>";

		echo "<aside class='right'>";
		if ($page->asideRight) include "content/components/" . $page->asideRight . ".php";
		echo "</aside>";

		echo "</div>";

		include "content/components/footer.php";
	}
}
