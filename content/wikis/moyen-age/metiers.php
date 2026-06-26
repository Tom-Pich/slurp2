<?php

use App\Lib\ListWriter;

$activities = include("src/Generator/lists/medieval-activities.php");
$separator = ceil(count($activities) / 2);
$activities_1 = array_slice($activities, 0, $separator);
$activities_2 = array_slice($activities, $separator);

?>

<p class="intro">Liste des métiers médiévaux, qui tente d’être exhaustive.</p>
<section class="grid col-2 gap-2">
	<?php foreach ([$activities_1, $activities_2] as $sublist): ?>
		<div class="mt-0 flow">
			<?php foreach ($sublist as $domain => $domain_activities): ?>
				<?php $domain = ListWriter::ucf($domain) ?>
				<details>
					<summary>
						<h4><?= $domain ?></h4>
					</summary>
					<ul <?= is_array(array_values($domain_activities)[0]) ? "class=\"flow\"" : "" ?>>
						<?= ListWriter::displayList($domain_activities) ?>
					</ul>
				</details>
			<?php endforeach ?>
		</div>
	<?php endforeach ?>
</section>