<h2 class="ta-center">Liste des scénarii</h2>

<?php
require_once "content/scenarii/_scenarii-data.php";
foreach ($scenarii_data as $url => $scenario){ ?>
	<div class="flow wrapper mt-2">
		<h3><a href="/scenario/<?= $url ?>" class="nude"><?= $scenario["title"] ?></a></h3>
		<p class="italic"> Un scénario pour <?= $scenario["universe"] ?></p>
		<p><?= $scenario["excerpt"] ?></p>
	</div>
<?php } ?>