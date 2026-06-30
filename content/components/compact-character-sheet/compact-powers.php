<?php
$power_display_array = [];
foreach ($character->powers as $pouvoir):
	$clr_style = color_modifier(0, $character->modifiers["Int"]);
	$power_display_array[] = "<span data-type='throwable-wrapper'><span data-type='throwable-label'>{$pouvoir["label"]}</span><span data-type='throwable-score' $clr_style > {$pouvoir["score"]}</span></span>";
endforeach;
?>

<p class="ta-left"><?= join(" ; ", $power_display_array) ?></p>