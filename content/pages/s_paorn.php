<?php

include "content/wiki/paorn/_articles_data.php";
$admin = $_SESSION["Statut"] >= 3;

?>

<aside class="nav p-1">
	<h4 class="mb-½">Articles</h4>
	<?php
	foreach ($articles as $name => $title) {
		$article_is_subsection = substr($title, -1) === "*";
		if ($article_is_subsection) $title = substr($title, 0, -1);
	?>
		<p class="<?= $page["article"] === $name ? "active" : "" ?> <?= $article_is_subsection ? "subsection" : "" ?>">
			<a href="/wiki-paorn/<?= $name ?>"><?= $title ?></a>
		</p>
	<?php } ?>
</aside>

<div class="article-wrapper">
	<?php if ($page["article"]) {
		include "content/wiki/paorn/" . $page["article"] . ".php";
	} else { ?>
		<p><i>Sélectionnez un article à afficher</i></p>
	<?php }
	?>
</div>