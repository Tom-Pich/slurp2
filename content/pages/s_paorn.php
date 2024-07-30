<?php

$admin = $_SESSION["Statut"] >= 3;

function lk($name)
{
	global $page_data;
	if ($name === "home"){
		$output = "href='/wiki-paorn/' ";
		if (empty($page_data["article"])) $output .= "class='active-link'";
	} else {
		$output = "href='/wiki-paorn/" . $name . "' ";
		if ( !empty($page_data["article"]) && $page_data["article"] === $name) $output .= "class='active-link'";
	}
	return $output;
}

?>

<aside class="nav p-½">
	<p><a <?= lk("home") ?>>Accueil</a></p>
	<h4>Régions</h4>
	<p><a <?= lk("artaille") ?>>Artaille</a></p>
	<p><a <?= lk("lauria") ?>>Lauria</a></p>

	<h4>Villes de Burgonnie</h4>
	<p><a <?= lk("imegie") ?>>Imégie</a></p>
	<ul>
		<li><a <?= lk("auberge-vieille-tour") ?>>Auberge de la Vieille Tour</a></li>
	</ul>
	<p><a <?= lk("almisie") ?>>Almisie</a></p>
	<p><a <?= lk("stomilie") ?>>Stomilie</a></p>
	<p><a <?= lk("port-goshal") ?>>Port Goshal</a></p>

	<h4>Organisations</h4>
	<p><a <?= lk("arcania") ?>>Arcania</a></p>
	<p><a <?= lk("atrimisme") ?>>Atrimisme</a></p>
</aside>

<div class="article-wrapper">
	<?php include "content/wiki/paorn/" . ($page["article"] ?? "home") . ".php";  ?>
</div>