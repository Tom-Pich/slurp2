<?php
$psi_display_list = [];
foreach ($character->psi as $pouvoir) {
	if (in_array($discipline["id"], $pouvoir["data"]->disciplines) && $pouvoir["readable-score"]) {
		$clr_style = color_modifier(0, $character->modifiers["Int"]);
		$label = $pouvoir["data"]->name;
		$niv = $pouvoir["data"]->readableNiv;
		$cost = $pouvoir["readable-cost"];
		$score = $pouvoir["readable-score"];

		$psi_display_list[] = "<span data-type='throwable-wrapper'><span data-type='throwable-label'>$label ($niv) [$cost]</span><span data-type='throwable-score' $clr_style > $score</span></span>";
	}
}
?>

<p class="ta-left">
	<b><?= $discipline["nom"] ?> (Niv. <?= $discipline["niv"] ?>)</b>
	<?= isset($discipline["notes"]) ? "(<i>{$discipline["notes"]}</i>)" : "" ?>
	–
	<?= join(" ; ", $psi_display_list) ?>
</p>