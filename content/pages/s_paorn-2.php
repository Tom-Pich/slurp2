<?php
$article_query = $_GET["article"] ?? null;
$article_file = $article_query ? "content/wiki/paorn/" . $article_query . ".php" : null;

$articles = [ // see list in content/wiki/paorn folder
	"arcania" => "Arcania (organisation)",
	"artaille" => "Artaille (région)",
	"atrimisme" => "Atrimisme (religion)",
	"imegie" => "Imégie (ville)",
	"auberge-vieille-tour" => "Auberge de la Vieille Tour*",
	"lauria" => "Lauria (région)",
	"port-goshal" => "Port Goshal (ville)",
];

$admin = $_SESSION["Statut"] >= 3;

?>

<aside class="nav p-1">
	<h4 class="mb-½">Articles</h4>
	<?php
	foreach ($articles as $name => $title) {
		$article_is_subsection = substr($title, -1) === "*";
		if ($article_is_subsection) $title = substr($title, 0, -1);
	?>
		<p class="<?= $article_query === $name ? "active" : "" ?> <?= $article_is_subsection ? "subsection" : "" ?>">
			<a href="?article=<?= $name ?>"><?= $title ?></a>
		</p>
	<?php } ?>
</aside>

<div class="article-wrapper">
	<?php if ($article_file && is_file($_SERVER["DOCUMENT_ROOT"] . "/" . $article_file)) {
		include $article_file;
	} else { ?>
		<p><i>Sélectionnez un article à afficher</i></p>
	<?php }
	?>
</div>