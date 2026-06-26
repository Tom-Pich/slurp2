<?php

namespace App\Controller;


class PageController
{
	public string $name;			
	public string $title;
	public string $file;

	public string $titleTab;		// default $title
	public string $titleH1;			// default $title
	public string $description;		// default ""
	public string $bodyClass;		// default "standard-page"
	public string $category;		// default "standard-page"
	public int $version;			// default 4
	public string $asideLeft;		// default ""
	public string $asideRight;		// default ""
	public int $accessRestriction;	// default 0

	public string $displayMode;		// default "auto"
	public string $displayStyle;	// default "normal"
	public string $displayTheme;	// default "standard"

	public string $canonical;		// processed

	public function __construct(array $page_data)
	{
		// necessary
		$this->name = $page_data["name"];
		$this->title = htmlspecialchars($page_data["title"]);
		$this->file = $page_data["file"];

		// default fallback
		$this->titleTab = $page_data["titleTab"] ?? $page_data["title"];
		$this->titleH1 = $page_data["titleH1"] ?? $page_data["title"];
		$this->description = $page_data["description"] ?? "";
		$this->bodyClass = $page_data["body-class"] ?? "standard-page";
		$this->category = $page_data["category"] ?? "standard-page";
		$this->version = $page_data["version"] ?? 4;
		$this->asideLeft = $page_data["aside-left"] ?? "";
		$this->asideRight = $page_data["aside-right"] ?? "";
		$this->accessRestriction = $page_data["access-restriction"] ?? 0;

		// user options
		$this->displayMode = $_SESSION["user-options"]["mode"] ?? "auto";
		$this->displayStyle = $_SESSION["user-options"]["style"] ?? "normal";
		$this->displayTheme = $_SESSION["user-options"]["theme"] ?? "standard";

		// processed data
		$canonical_url = $this->name === "home" ? "" : "/" . $this->name;
		if (str_ends_with($canonical_url, "/home")) $canonical_url = substr($canonical_url, 0, -5);
		$this->canonical = "https://jdr.pichegru.net" . $canonical_url;

	}

	public function show($payload = NULL)
	{
		$page = $this;
		$page_file = "content/pages/" . $page->file . ".php";
		
		// wiki specific
		if ($page->file === "wiki-page"){
			$article_references = explode( "/", $page->name);
			$wiki = $article_references[1];
			$article_name = $article_references[2];
			$page_file = "content/wikis/" . $wiki . "/" . $article_name . ".php";
			$page->titleTab = $page->category . ($article_name === "home" ? "" : " – " . $page->title);
		}

		include "content/components/header.php";

		//var_dump($page);

		echo "<div id='page-wrapper'>";

		echo "<aside class='left'>";
		if ($page->asideLeft) include "content/components/" . $page->asideLeft . ".php";
		echo "</aside>";

		echo "<main>";
		if ($page->file === "wiki-page") echo "<h1>" . $page->titleH1 . "</h1>";
		include $page_file;
		echo "</main>";

		echo "<aside class='right'>";
		if ($page->asideRight) include "content/components/" . $page->asideRight . ".php";
		echo "</aside>";

		echo "</div>";

		include "content/components/footer.php";
	}
}
