<?php

namespace App\Controller;

use App\Repository\CollegeRepository;
use App\Repository\SpellRepository;

class GenerateMagicController
{
	private string $outputPath;

	public function __construct()
	{
		$this->outputPath = __DIR__ . "/../../scenarii/ressources-ia/magic.md";
	}

	public function generate(): void
	{
		$collegeRepo = new CollegeRepository;
		$spellRepo   = new SpellRepository;

		$colleges     = $collegeRepo->getAllColleges();
		$spells       = $spellRepo->getAllSpells();
		$collegeNames = $collegeRepo->getCollegesName();

		$date = (new \DateTime())->format("d/m/Y à H:i");
		$md   = "# Magie\n\n";
		$md  .= "_Généré le {$date}_\n\n";
		$md  .= "---\n\n";

		// ── Section 1 : collèges ──────────────────────────────────────────────
		$md .= "## Collèges de magie\n\n";

		foreach ($colleges as $college) {
			$md .= "### {$college->name}\n\n";
			$description = $this->toPlainText($college->description);
			if ($description) {
				$md .= "{$description}\n\n";
			}
		}

		$md .= "---\n\n";

		// ── Section 2 : sorts (ordre alphabétique) ───────────────────────────
		$md .= "## Sorts\n\n";

		foreach ($spells as $spell) {
			$niv = $spell->readableNiv ? " ({$spell->readableNiv})" : "";
			$md .= "### {$spell->name}{$niv}\n\n";

			// Collèges
			$spellColleges = [];
			foreach ($spell->colleges as $cid) {
				if (isset($collegeNames[$cid])) {
					$spellColleges[] = $collegeNames[$cid];
				}
			}
			if (!empty($spellColleges)) {
				$label = count($spellColleges) > 1 ? "Collèges" : "Collège";
				$md .= "- **{$label} :** " . implode(", ", $spellColleges) . "\n";
			}

			if ($spell->class)      $md .= "- **Classe :** {$spell->class}\n";
			if ($spell->duration)   $md .= "- **Durée :** " . $this->toPlainText($spell->duration) . "\n";
			if ($spell->time)       $md .= "- **Temps :** " . $this->toPlainText($spell->time) . "\n";
			if ($spell->zone)       $md .= "- **Zone :** " . $this->toPlainText($spell->zone) . "\n";
			if ($spell->resistance) $md .= "- **Résistance :** " . $this->toPlainText($spell->resistance) . "\n";
			if ($spell->origin)     $md .= "- **Origine :** {$spell->origin}\n";

			$description = $this->toPlainText($spell->description);
			if ($description) {
				$md .= "\n{$description}\n";
			}

			$md .= "\n";
		}

		file_put_contents($this->outputPath, $md);

		$spellCount   = count($spells);
		$collegeCount = count($colleges);
		echo "<p style='font-family:sans-serif; padding:2rem'>✅ Fichier <code>scenarii/ressources-ia/magic.md</code> généré avec succès.<br>{$collegeCount} collèges · {$spellCount} sorts.</p>";
	}

	/**
	 * Convert HTML content to plain text suitable for Markdown.
	 */
	private function toPlainText(string $html): string
	{
		// Replace block-level tags with newlines before stripping
		$text = preg_replace('/<br\s*\/?>/i', "\n", $html);
		$text = preg_replace('/<\/p>/i', "\n", $text);
		$text = preg_replace('/<p[^>]*>/i', "", $text);
		$text = strip_tags($text);
		$text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$text = preg_replace("/\n{3,}/", "\n\n", trim($text));
		return $text;
	}
}
