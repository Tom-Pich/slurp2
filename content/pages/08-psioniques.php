<?php

use App\Entity\Discipline;
use App\Lib\TextParser;
use App\Repository\AvDesavRepository;
use App\Repository\DisciplineRepository;
use App\Repository\PsiPowerRepository;

$avdesav_repo = new AvDesavRepository;
$avdesav_list = $avdesav_repo->getAvDesavByCategory("Psi");
$disciplines_repo = new DisciplineRepository;
$powers_repo = new PsiPowerRepository;

$affichage = $_POST["affichage"] ?? "categorie";
$_POST["niv"] = $_POST["niv"] ?? [1 => "on", 2 => "on", 3 => "on", 4 => "on", 5 => "on",];

// $_POST processing
$niv_min = min(array_keys($_POST["niv"]));
$niv_max = max(array_keys($_POST["niv"]));
?>

<!-- Généralités -->
<article class="as-start">
	<h2>Généralités</h2>

	<details>
		<summary><h3>Principes directeurs</h3></summary>
		<p>Les pouvoirs psis supposent que certains esprits peuvent interagir avec la matière, champs électromagnétiques, les «&nbsp;énergies subtiles des corps&nbsp;» (qi, shakra, etc&hellip;), les autres esprits (incarnés ou pas) et les «&nbsp;plans d’existence&nbsp;».</p>
		<p>La puissance et la maîtrise d’un pouvoir psi sont presque totalement dissociées. Il est possible de disposer d’une grande puissance mal maîtrisée ou, inversement, d’une faible puissance très bien maîtrisée.</p>
	</details>

	<details>
		<summary><h3>Disciplines</h3></summary>
		<p>Les pouvoirs psi sont rattachés à des <i>Disciplines</i> recouvrant un champ d’action particulier. Chaque discipline est un <i>Avantage</i> comptant cinq niveaux, qui représentent la puissance brute de l’initiateur dans cette discipline. Ces avantages, quel que soit leur niveau, ne procurent aucun bonus aux jets de compétences portant sur les pouvoirs psi.</p>
		<p>Pour pouvoir utiliser des pouvoirs psi d’une discipline donnée, il faut avoir l’avantage disciplinaire correspondant, à un niveau au moins égal au niveau de puissance du pouvoir utilisé.</p>

		<table class="left-1">
			<tr>
				<th>Niveau de la discipline</th>
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
			</tr>
			<tr>
				<th>Coût en pts de personnage</th>
				<td><?= Discipline::costs[0] ?></td>
				<td><?= Discipline::costs[1] ?></td>
				<td><?= Discipline::costs[2] ?></td>
				<td><?= Discipline::costs[3] ?></td>
				<td><?= Discipline::costs[4] ?></td>
			</tr>
		</table>

		<h4>Maîtrise de plusieurs disciplines</h4>
		<p>Le coût des disciplines est dégressif&nbsp;: la discipline ayant le niveau le plus élévé est payée normalement, les autres disciplines peuvent être acquises à un coût réduit de moitié.</p>
		<details class="exemple">
			<summary>Exemple</summary>
			<p>Un joueur décide d'acquérir les disciplines <i>Télépathie</i> au niveau 3 et <i>Psychométabolisme</i> au niveau 2. La discipline <i>Télépathie</i> ayant le niveau le plus élevé, elle lui coûte 20 pts. <i>Psychométabolisme</i> lui coûte la moitié des points s’il la prend à un niveau inférieur ou égal à 3.</p>
		</details>
	</details>

	<details>
		<summary><h3>Pouvoirs</h3></summary>
		<p>Chaque pouvoir est une compétence I(-6). Les pouvoirs ont généralement des effets possibles plus vastes que les sorts.</p>
		<p>Un pouvoir possède les mêmes caractéristiques qu’un sort&nbsp;: niveaux de puissance, classe, durée et temps nécessaire à l’activation.</p>

		<h4>Effets des pouvoirs</h4>
		<p>Les effets de ces pouvoirs, lorsqu’ils agissent sur la matière ou l’énergie, doivent pouvoir être décrits en termes «&nbsp;scientifiques&nbsp;» avec une certaine cohérence, contrairement aux pouvoirs magiques. Cette description permettra d’imaginer d’autres effets du moment qu’ils sont compatibles avec l’action fondamentale du pouvoir sur la matière et l’énergie.</p>

		<h4>Niveaux de puissance</h4>
		<p>La plupart des pouvoirs ont des effets très variables selon leur puissance.</p>
		<p>Un pouvoir ne peut être utilisé à un niveau de puissance supérieur à celui de l’avantage disciplinaire correspondant dont le personnage dispose.</p>

		<h4>Améliorations &amp; limitations</h4>
		<p>
			Selon l’univers de jeu, il peut être possible d’appliquer une amélioration ou limitation d’un pouvoir surnaturel à tous les pouvoirs d’une discipline (jamais à un pouvoir seul).
		</p>
		<p>
			Amélioration et limitation spécifiques aux pouvoirs psis&nbsp;: <b>Aucune empreinte mentale</b> ou <b>Faible empreinte mentale&nbsp;:</b> l’utilisation du pouvoir ne laisse que peu (ou pas) de trace psychique.
		</p>
	</details>

	<details>
		<summary><h3>Psi &amp; magie</h3></summary>
		<p><i>Imperméabilité à la magie</i> ou <i>Résistance à la magie</i> n’ont aucun effet sur les pouvoirs psis. En revanche, il existe des avantages spécifiques&nbsp;:</p>
		<?php foreach ($avdesav_list as $avdesav) {
			$avdesav->displayInRules(show_edit_link: $_SESSION["Statut"] === 3);
		} ?>
		<p>Les pouvoirs psi ne sont pas affectés par le niveau de fluide.</p>
	</details>

</article>

<!-- Utiliser un pouvoir -->
<article class="as-start">
	<h2>Utiliser un pouvoir</h2>

	<details>
		<summary><h3>Modificateurs</h3></summary>
		<p>Le niveau de compétence d’un pouvoir souffre d’un malus selon le niveau de puissance employé : 0/-1/-2/-3/-4 et, parfois également, selon la difficulté de l’action à accomplir (cf. description du pouvoir).</p>
	</details>

	<details>
		<summary><h3>Temps, durée et portée</h3></summary>

		<h4>Temps nécessaire et rituels</h4>
		<p>Le déclenchement d’un pouvoir psi ne demande rien de plus qu’une concentration (aucun geste, aucune parole n’est nécessaire). Le <i>Temps nécessaire</i> peut être <i>Court</i> ou <i>Long</i>, la valeur exacte dépendant du niveau de puissance utilisée, comme pour les sorts.</p>
		<p>Ce <i>Temps nécessaire</i> ne diminue pas avec un score de compétence élevé, contrairement aux sorts.</p>

		<h4>Portée</h4>
		<p>Comme pour les sorts. La portée peut être doublée si l’initiateur produit un <i>Effort supplémentaire</i> (voir plus bas).</p>

		<h4>Durée et prolongation</h4>
		<p>Comme pour les sorts. La durée peut être augmentée si l’initiateur produit un <i>Effort supplémentaire</i> (voir plus bas). La durée passe alors à la «&nbsp;catégorie&nbsp;» supérieure (1 min → 10 min, 10 min → 1h, etc).</p>
	</details>

	<details>
		<summary><h3>Coût énergétique</h3></summary>
		<p>L’utilisation de pouvoirs psioniques peut fatiguer l’initiateur. Le coût énergétique d’un pouvoir se paie en PdF et dépend du niveau de puissance du pouvoir utilisé : 1/2/3/4/8 PdF.</p>
		<p>Ce coût ne décroît pas avec le score de compétence, mais il décroît avec le niveau de l’avantage disciplinaire dont dispose l’initiateur : -1 PdF pour une discipline au niveau III, -2 au niveau IV et -3 au niveau V.</p>
		<p>Les PdF dépensés par l’utilisation de pouvoirs psi sont récupérés au rythme de 1 PdF par 15 minutes de repos.</p>
	</details>

	<details>
		<summary><h3>Effort supplémentaire</h3></summary>
		<p>Il est possible d’augmenter la durée de base, la portée d’un pouvoir ou de transformer un pouvoir régulier en pouvoir de zone.<br />
			Ceci fonctionne exactement comme indiqué dans le chapitre <a href="/magie"><i>Magie</i></a>, au paragraphe <i>Créer ou modifier un sort</i> &gt; <i>Modifier un sort existant</i>.<br />
			Cet «&nbsp;effort supplémentaire&nbsp;» entraîne toujours une dépense de PdF minimale de 1 PdF et impose un malus au score de compétence du pouvoir de -3.</p>
	</details>

	<details>
		<summary><h3>Réussite et échec</h3></summary>
		<p><b>Réussite critique&nbsp;:</b> le pouvoir marche parfaitement et n’a aucun coût énergétique.</p>
		<p><b>Échec :</b> l’énergie psychique est libérée mais le pouvoir n’est pas contrôlé. Ses effets sont plus ou moins loin de ceux escomptés et toujours proportionnels à la puissance auquel le pouvoir est utilisé. Le personnage paie le coût énergétique du pouvoir comme s’il avait réussi son jet.</p>

		<table class="alternate-e left-2">
			<tr>
				<th>ME</th>
				<th>Effets</th>
			</tr>
			<tr>
				<th>1</th>
				<td>Effets assez éloignés de ceux voulus mais pas néfastes</td>
			</tr>
			<tr>
				<th>2-3</th>
				<td>Effets proches de ceux attendus mais «&nbsp;maladroits&nbsp;»</td>
			</tr>
			<tr>
				<th>4-5</th>
				<td>Effets assez néfastes pour l’entourage (et lui-même)</td>
			</tr>
			<tr>
				<th>&ge; 6</th>
				<td>Effets très néfastes pour l’entourage (et lui-même)</td>
			</tr>
		</table>

		<p><b>Échec critique :</b> l’énergie nécessaire a été dépensée mais le pouvoir n’agit pas. L’énergie psychique se retourne contre son utilisateur et l’affecte physiquement (maux de tête, crampes, voire lésions et dégâts réels). Les PdF investis ne sont récupérés qu’au rythme d’un par jour.</p>

		<table class="alternate-o left-2">
			<tr>
				<th>1-3</th>
				<td>Maux de têtes plus ou moins violents durant 1d à 3d minutes (-1 à -3 à tous les jets) mais sans perte de PdV.</td>
			</tr>
			<tr>
				<th>4</th>
				<td>Vertiges. -3 à toutes les compétences. Perte de 1d PdF. Si cela amène le personnage à un score de fatigue négatif, il reste inconscient jusqu’à récupération (normale) des PdF négatifs.</td>
			</tr>
			<tr>
				<th>5</th>
				<td>Saignement du nez. Perte de 1 PdV. Jet de <i>San</i>+5, perte définitive d’un pt de <i>Vol</i> en cas d’échec.</td>
			</tr>
			<tr>
				<th>6</th>
				<td>Lésion cérébrale. Le personnage prend des dégâts «&nbsp;standard&nbsp;» correspondant au niveau du pouvoir moins un. Jet de <i>San</i>, perte d’un point de <i>Int</i> et de <i>Vol</i> en cas d’échec.</td>
			</tr>
		</table>

	</details>

	<details>
		<summary><h3>Résistance aux pouvoirs psi</h3></summary>
		<p>Résister aux pouvoirs psi se fait de la même manière que résister à des sorts.</p>
	</details>

</article>

<!-- Liste des pouvoirs -->
<article class="as-start" data-role="spells-wrapper">
	<h2>
		<?php if ($_SESSION["Statut"] === 3) { ?><a href="gestion-listes?req=psi&id=0" class="nude ff-far">&#xf044;</a><?php } ?>
		Liste des pouvoirs
	</h2>

	<fieldset class="full-width">
		<form method="post" action="/psioniques">

			<div class="flex-s gap-½">
				<div class="fl-1"><b>Affichage&nbsp;:</b></div>
				<label for="alpha">
					<input type="radio" name="affichage" value="alpha"  <?= $affichage == "alpha" ? "checked" : "" ?> onchange="this.form.submit()" />
					alphabétique
				</label>&nbsp;
				<label for="discipline">
					<input type="radio" name="affichage" value="categorie" <?= $affichage == "categorie" ? "checked" : "" ?> onchange="this.form.submit()" />
					disciplines
				</label>
			</div>

			<div class="ta-center mt-½">
				Niveaux
				<input type="text" data-role="range-filter" style="width: 5ch;" class="ta-center p-0" placeholder="1-5" value="1-5">
			</div>
		</form>
	</fieldset>


	<?php

	$liste_disciplines = $disciplines_repo->getAllDisciplines();

	if ($affichage === "alpha") {
		$pouvoirs = $powers_repo->getAllPowers();
		if ($niv_max < 5 || $niv_min > 1) {
			$pouvoirs = array_filter($pouvoirs, fn ($pouvoir) => $pouvoir->data->niv_min <= $niv_max && $pouvoir->data->niv_max >= $niv_min);
		}
		foreach ($pouvoirs as $pouvoir) {
			$pouvoir->displayInRules(show_edit_link: $_SESSION["Statut"] === 3);
		}
	} else {
		foreach ($liste_disciplines as $discipline) { ?>
			<details data-role="college-wrapper">
				<summary><h3><?= $discipline->name ?></h3></summary>
				<p> <?= $discipline->description ?></p>
				<?php
				$pouvoirs = $powers_repo->getPowersByDiscipline($discipline->id);
				if ($niv_max < 5 || $niv_min > 1) {
					$pouvoirs = array_filter($pouvoirs, fn ($pouvoir) => $pouvoir->data->niv_min <= $niv_max && $pouvoir->data->niv_max >= $niv_min);
				}
				foreach ($pouvoirs as $pouvoir) {
					$pouvoir->displayInRules(show_edit_link: $_SESSION["Statut"] === 3);
				}
				?>
			</details>
	<?php
		}
	}
	?>

</article>

<script type="module" src="/scripts/spells-powers-filter.js?v=2" defer></script>