<?php
$admin = $_SESSION["Statut"] >= 3;
$wiki = $page["wiki"];
$articles = $page["articles"];
$current_article = $page["current-article"];
$sections = [];
foreach ($articles as $article){
	if (isset($article["section"])) $sections[] = $article["section"];
}
$sections = array_unique($sections);
$articles_without_section = array_filter($articles, fn($x) => !isset($x["section"]) && !isset($x["parent"]) );

function lk($name, $current_article){
	if ($current_article === $name) return "class='active-link'";
}
?>

<aside class="nav p-½">
	<p><a href="/wiki/<?= $wiki ?>" <?= lk("home", $current_article) ?> >Accueil</a></p>

	<!-- Articles hors section -->
	 <?php foreach ($articles_without_section as $name => $article){ ?>
		<p><a href="/wiki/<?= $wiki ?>/<?= $name ?>" <?= lk($name, $current_article) ?>><?= $article["title"] ?></a></p>
	 <?php } ?>

	 <!-- Sections -->
	  <?php foreach ($sections as $section){ ?>
		<h4><?= $section ?></h4>
		<?php
		$section_articles = array_filter($articles, fn($x) => isset($x["section"]) && $x["section"] === $section || isset($x["parent"]) && $articles[$x["parent"]]["section"] === $section );
		foreach ($section_articles as $name => $article){ ?>
			<p <?= isset($article["parent"]) ? "class='child-article'" : "" ?> >
				<a href="/wiki/<?= $wiki ?>/<?= $name ?>" <?= lk($name, $current_article) ?>><?= $article["title"] ?></a>
			</p>
		<?php }
		?>
		
	  <?php } ?>


</aside>

<div class="article-wrapper">
	<?php include "content/wikis/" . $wiki . "/" . $current_article . ".php";  ?>
</div>