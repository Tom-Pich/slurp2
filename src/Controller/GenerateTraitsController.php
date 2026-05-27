<?php

namespace App\Controller;

use App\Controller\AbstractGenerateController;
use App\Repository\AvDesavRepository;

class GenerateTraitsController extends AbstractGenerateController
{
	private string $outputPath;

	public function __construct()
	{
		$this->outputPath = __DIR__ . "/../../scenarii/ressources-ia/avdesav.md";
	}

	public function generate(): void
	{
		$repo = new AvDesavRepository;

		$categories  = $repo->getDistinctCategories();
		$traitCount  = 0;

		$date = (new \DateTime())->format("d/m/Y à H:i");
		$md   = "# Avantages & Désavantages\n\n";
		$md  .= "_Généré le {$date}_\n\n";
		$md  .= "---\n\n";

		foreach ($categories as $category) {
			$traits = $repo->getAvDesavByCategory($category);
			if (empty($traits)) continue;

			$md .= "## {$category}\n\n";

			foreach ($traits as $trait) {
				$cost = $trait->displayCost();
				$md  .= "### {$trait->name} ({$cost})\n\n";

				if ($trait->description) {
					$md .= $this->toPlainText($trait->description) . "\n";
				}

				$md .= "\n";
				$traitCount++;
			}
		}

		$md .= "--- Fin du fichier";

		file_put_contents($this->outputPath, $md);

		$catCount = count($categories);
		echo "<p style='font-family:sans-serif; padding:2rem'>✅ Fichier <code>scenarii/ressources-ia/avdesav.md</code> généré avec succès.<br>{$catCount} catégories · {$traitCount} avantages &amp; désavantages.</p>";
	}
}
