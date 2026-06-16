<?php

namespace App\Controller;

use App\Controller\AbstractGenerateController;
use App\Repository\SkillRepository;

class GenerateSkillsController extends AbstractGenerateController
{
	private string $outputFile;
	private string $outputPath;

	public function __construct()
	{
		$this->outputFile = "liste-competences.md";
		$this->outputPath = __DIR__ . "/../../scenarii/ressources-ia/" . $this->outputFile;
	}

	public function generate(): void
	{
		$repo = new SkillRepository;

		$categories = $repo->getDistinctCategories();
		$skillCount = 0;

		$date = (new \DateTime())->format("d/m/Y à H:i");
		$md   = "# Compétences\n\n";
		$md  .= "_Généré le {$date}_\n\n";
		$md  .= "---\n\n";

		foreach ($categories as $category) {
			$skills = $repo->getSkillsByCategory($category);
			if (empty($skills)) continue;

			$md .= "## {$category}\n\n";

			foreach ($skills as $skill) {
				$md .= "### {$skill->name}";
				$md .= " – {$skill->base}{$skill->readableDifficulty}";
				$md .= "\n\n";

				if ($skill->description) {
					$md .= $this->toPlainText($skill->description) . "\n";
				}

				$md .= "\n";
				$skillCount++;
			}
		}

		$md .= "--- Fin du fichier";

		file_put_contents($this->outputPath, $md);

		$catCount = count($categories);
		echo "<p style='font-family:sans-serif; padding:2rem'>✅ Fichier <code>scenarii/ressources-ia/{$this->outputFile}</code> généré avec succès.<br>{$catCount} catégories · {$skillCount} compétences.</p>";
	}
}
