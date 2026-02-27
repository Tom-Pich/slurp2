<?php
$wiki = $page["wiki"];
$articles = $page["articles"];
$article = $page["current-article"];
$article_name = $page["current-article-name"];
$url_root = "/wiki/" . $wiki;
$sections = [];
foreach ($articles as $a) if (isset($a["section"])) $sections[] = $a["section"];
$sections = array_unique($sections);

// link class in table of content
function lk_classes(string $title, string $current_title, bool $has_parent)
{
	$classes = "";
	if ($current_title === $title) $classes .= "active-link ";
	if ($has_parent) $classes .= "child-article";
	if ($classes !== "") return "class='" . trim($classes) . "'";
}
?>

<p id="show-wiki-nav">Sommaire</p>

<!-- Accueil -->
<a href="<?= $url_root ?>" <?= lk_classes("home", $article_name, false) ?>>Accueil</a>

<!-- Articles hors section -->
<?php
$articles_without_section = array_filter(
	$articles,
	fn($a, $index) => !isset($a["section"]) && !isset($a["parent"]) && $index !== "home",
	ARRAY_FILTER_USE_BOTH
); ?>
<?php foreach ($articles_without_section as $name => $article): ?>
	<a href="/wiki/<?= $wiki ?>/<?= $name ?>" <?= lk_classes($name, $article_name, false) ?>><?= $article["title"] ?></a>
<?php endforeach ?>

<!-- Sections -->
<?php
foreach ($sections as $section) {
	$main_article = array_filter($articles, fn($x) => isset($x["section"]) && $x["section"] === $section && $x["title"] === $section);
	$link_open = "";
	$link_close = "";
	if ($main_article) {
		$main_article_name = array_keys($main_article)[0];
		$link_open = "<a href='{$url_root}/{$main_article_name}'>";
		$link_close = "";
	}
	$section_articles = array_filter(
		$articles,
		fn($x) => isset($x["section"]) && $x["section"] === $section && $x["title"] !== $section ||
			isset($x["parent"]) && $articles[$x["parent"]]["section"] === $section
	);
?>
	<h4><?= $link_open . $section . $link_close ?></h4>
	<?php foreach ($section_articles as $name => $article): ?>
		<a href="<?= $url_root ?>/<?= $name ?>" <?= lk_classes($name, $article_name, isset($article["parent"])) ?>>
			<?= $article["title"] ?> <?= $article["status"] ?? "" ?>
		</a>
	<?php endforeach ?>

<?php } ?>