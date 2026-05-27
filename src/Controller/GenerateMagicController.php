<?php

namespace App\Controller;

use App\Controller\AbstractGenerateController;
use App\Repository\CollegeRepository;
use App\Repository\SpellRepository;

class GenerateMagicController extends AbstractGenerateController
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
		$spellCount	  = 0;

		$date = (new \DateTime())->format("d/m/Y à H:i");
		$md   = "# Magie\n\n";
		$md  .= "_Généré le {$date}_\n\n";
		$md  .= "---\n\n";

		foreach ($colleges as $college) {
			$md .= "## {$college->name}\n\n";
			$description = $this->toPlainText($college->description);
			$md .= "**Description du collège :** {$description}\n\n";

			$spells = $spellRepo->getSpellsByCollege($college->id);

			foreach ($spells as $spell) {
				$niv = $spell->readableNiv;
				$md .= "### {$spell->name} ({$niv})\n\n";

				if ($spell->class)      $md .= "- **Classe :** {$spell->class}\n";
				if ($spell->duration)   $md .= "- **Durée :** " . $this->toPlainText($spell->duration) . "\n";
				if ($spell->time)       $md .= "- **Temps :** " . $this->toPlainText($spell->time) . "\n";
				if ($spell->zone)       $md .= "- **Zone :** " . $this->toPlainText($spell->zone) . "\n";
				if ($spell->resistance) $md .= "- **Résistance :** " . $this->toPlainText($spell->resistance) . "\n";

				$description = $this->toPlainText($spell->description);
				$md .= "\n{$description}\n";

				$md .= "\n";
				$spellCount ++;
			}
		}

		$md .= "--- Fin du fichier";

		file_put_contents($this->outputPath, $md);

		$collegeCount = count($colleges);
		echo "<p style='font-family:sans-serif; padding:2rem'>✅ Fichier <code>scenarii/ressources-ia/magic.md</code> généré avec succès.<br>{$collegeCount} collèges · {$spellCount} sorts.</p>";
	}
}
