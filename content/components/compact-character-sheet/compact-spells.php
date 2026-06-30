<?php
$college_display = "<b>" . $college["name"] . " <span $clr_style>" . $college["score"] . "</span></b>";
$spell_display_array = [];
foreach ($character->spells as $spell) {
	if (in_array($college["id"], $spell["data"]->colleges) && (max($spell["scores"]) >= 12)) {
		$spell_display_array[] = "<span data-type='throwable-wrapper'><span data-type='throwable-label'>{$spell["label"]} [{$spell["readable_costs"]}]</span><span data-type='throwable-score'> {$spell["readable_scores"]}</span></span>";
	}
} ?>

<p class="ta-left"><?= $college_display . " – " . join(", ", $spell_display_array) ?></p>