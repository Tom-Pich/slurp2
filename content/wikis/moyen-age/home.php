<p>Ce wiki contient quelques informations glanées çà et là sur le Moyen Âge. J’essaye de réunir des informations fiables sur la vie quotidienne à cette époque, quitte à parfois simplifier un peu.</p>

<p>L’objectif de ce wiki n’est pas de fournir des informations d’une rigueur historique absolue, mais plutôt de proposer un cadre de référence permettant de développer et d’animer un monde médiéval crédible – ou de s’en éloigner en connaissance de cause.</p>

<h3>Rubriques</h3>
<div class="grid col-2 gap-1">
	<!-- Sommaire -->
	<?php
	$articles = array_filter($articles, fn($a) => $a !== "home", ARRAY_FILTER_USE_KEY);
	$sections = array_map(fn($a) => $a["section"], $articles);
	$sections = array_unique($sections);
	
	foreach ($sections as $s):
	?>
	
		<div class="border-grey-700 border-radius-1 box-shadow p-1 flow">
			<h4><?= $s ?></h4>
			<ul>
			<?php $related_articles =  array_filter($articles, fn($a) => $a["section"] == $s); ?>
			<?php foreach ($related_articles as $name => $a): ?>
				<li><a href="/wiki/moyen-age/<?= $name ?>" class="td-none"><?= $a["title"] ?></a></li>
			<?php endforeach ?>
			</ul>
		</div>
	
	<?php endforeach ?>
</div>