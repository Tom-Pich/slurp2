<?php
$skill_display_array = [];
foreach ($character->skills as $comp) {
	$clr_style = color_modifier($comp["raw-base"], $comp["base"]);
	$skill_display_array[] = "<span data-type='throwable-wrapper'><span data-type='throwable-label'>{$comp["label"]}</span><span data-type='throwable-score' $clr_style > {$comp["score"]}</span></span>";
}
?>

<p class="ta-left"><?= join(" ; ", $skill_display_array) ?></p>