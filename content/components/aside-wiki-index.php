<?php
$wiki = $page["wiki"];
$articles = $page["articles"];
$article = $page["current-article"];
$sections = [];
foreach ($articles as $a) if (isset($a["section"])) $sections[] = $a["section"];
$sections = array_unique($sections);

$articles_without_section = array_filter(
	$articles,
	fn($a, $index) => !isset($a["section"]) && !isset($a["parent"]) && $index !== "home",
	ARRAY_FILTER_USE_BOTH
);

function lk_classes(string $title, string $current_title, bool $has_parent) {
	$classes = "";
	if ($current_title === $title) $classes .= "active-link ";
	if ($has_parent) $classes .= "child-article";
	if ($classes !== "") return "class='" . $classes . "'";
}
?>

<a href="/wiki/<?= $wiki ?>" <?= lk_classes("home", $page["current-article-name"], false) ?>>Accueil</a>

<!-- Articles hors section -->
<?php foreach ($articles_without_section as $name => $article) { ?>
	<a href="/wiki/<?= $wiki ?>/<?= $name ?>" <?= lk_classes($name, $page["current-article-name"], false) ?>><?= $article["title"] ?></a>
<?php } ?>

<!-- Sections -->
<?php foreach ($sections as $section) { ?>
	<h4><?= $section ?></h4>
	<?php
	$section_articles = array_filter($articles, fn($x) => isset($x["section"]) && $x["section"] === $section || isset($x["parent"]) && $articles[$x["parent"]]["section"] === $section);
	foreach ($section_articles as $name => $article) { ?>
		<a href="/wiki/<?= $wiki ?>/<?= $name ?>" <?= lk_classes($name, $page["current-article-name"], isset($article["parent"])) ?>>
			<?= $article["title"] ?>
		</a>
	<?php }
	?>

<?php } ?>