<?php

use App\Lib\Sorter;
use App\Repository\AvDesavRepository;
use App\Repository\PowerRepository;

$repo_avdesav = new AvDesavRepository;
$repo_powers = new PowerRepository("ins");

?>

<!-- Personnage -->
<article>
	<h2>Personnage</h2>

	<!-- Pts de personnage -->
	<details>
		<summary>
			<h3>Points de personnage</h3>
		</summary>
		<p><b>Personnage débutant&nbsp;:</b> 230 pts (anges) ou 220 pts (démons)</p>
		<ul>
			<li><b>Caractéristiques&nbsp;:</b> 100 à 130 pts</li>
			<li><b>Avantages &amp; désavantages&nbsp;:</b> -10 à 10 pts</li>
			<li><b>Compétences&nbsp;:</b> 15 à 30 pts</li>
			<li><b>Pouvoirs&nbsp;:</b> 40 à 70 pts</li>
		</ul>
	</details>

	<!-- Incarnation et supérieur -->
	<details>
		<summary>
			<h3>Incarnation &amp; supérieur</h3>
		</summary>
		<p>Les anges et démons s’incarnent dans un corps humain <b>créé</b> pour l’occasion (contrairement à la version officielle du jeu).</p>
		<p>Chaque ange ou démon est affilié à un <i>Archange</i> ou à un <i>Prince-Démon</i>. Ce choix va guider la création du personnage et sa philosophie une fois incarné.</p>
	</details>

	<!-- Avantages & désavantages -->
	<details>
		<summary>
			<h3>Avantages &amp; Désavantages</h3>
		</summary>
		<p><b>• Alphabétisation&nbsp;:</b> les anges et démons savent lire et écrire toutes les langues de l’Humanité.</p>
		<p><b>• Richesse&nbsp;:</b> les anges et le démons s’incarnent nus&nbsp;! Le problème du financement se règle ensuite par leur QG ou par leur propres moyens.</p>
		<p><b>• PdM supplémentaires&nbsp;:</b> un ange ou un démon a le droit d’acheter 1 PdM supplémentaire pour chaque niveau de pouvoir dont il dispose (y compris les pouvoirs de type <i>Avantage surnaturel</i>, qui sont considérés comme de niveau I). Un pouvoir de niveau IV permet donc d’acheter jusqu'à 4 PdM supplémentaire.</p>
		<p><b>• Réputation &ndash; Administration (3 pts/niv)&nbsp;:</b> le personnage n'est pas inconnu des «&nbsp;services administratifs&nbsp;» dont il dépend.</p>

		<h4>Packs Ange et Démon</h4>
		<p>Ces packs comprennent un ensemble de modificateurs et pouvoirs communs à tous les Anges et Démons.</p>
		<?php
		$pack_ange = $repo_avdesav->getAvDesav(165);
		$pack_ange->displayInRules();
		$pack_demon = $repo_avdesav->getAvDesav(166);
		$pack_demon->displayInRules();
		?>

		<h4>Code de conduite des Anges</h4>
		<ol>
			<li>Loyauté absolue envers les forces du Bien.</li>
			<li>Détruire sans pitié les forces du Mal.</li>
			<li>Respect du <i>Principe de discrétion</i>.</li>
			<li>Aidez les êtres humains en détresse.</li>
			<li>Prêchez la bonne parole.</li>
		</ol>

		<h4>Code de conduite des Démons</h4>
		<ol>
			<li>Loyauté absolue envers les forces du Mal.</li>
			<li>Détruire sans pitié les forces du Bien.</li>
			<li>Respect du <i>Principe de discrétion</i>.</li>
			<li>Détourner l’Humanité du Salut.</li>
		</ol>

		<h4>Limitations</h4>
		<p>Les <i>Limitations</i> sont des désavantages liés à un défaut d’incarnation. Elles peuvent contribuer à rendre un personnage intéressant et amusant à jouer. À traiter comme des désavantages classiques.</p>
		<p>
			<b>• Défauts d’incarnation&nbsp;:</b> le corps du personnage n’est pas idéal (âge, handicap, corpulence, etc.) ou présente un désavantage surnaturel (voir juste après).<br>
			<b>• Vices &amp; Vertus&nbsp;:</b> le personnage possède un vice (si c’est un ange) ou une vertu (si c’est un démon), correspondant à un <i>Trait de caractère</i> (à -5 pts minimum). Le personnage doit cacher ce trait de caractère s’il ne veut pas avoir d’ennui avec sa hiérarchie.<br>
			<b>• Phobies&nbsp;:</b> généralement une phobie légère.<br>
			<b>• Besoin&nbsp;:</b> le personnage doit assouvir un besoin quotidien sous peine de ne pas pouvoir récupérer de PdM. Entre -5 et -15 pts.<br>
			<b>• Troubles psychologiques&nbsp;:</b> le personnage souffre d’un problème mental grave à la suite d’un problème d’incarnation. Exemples&nbsp;: <i>Schizophrénie</i>&nbsp;; <i>Flash-back</i>&nbsp;; <i>Maniaco-dépressif</i>&nbsp;; <i>Épilepsie</i>&nbsp;; <i>Sur le fil du rasoir</i>&nbsp;; <i>Amnésie</i>.
		</p>

		<h4>Désavantages surnaturels</h4>
		<p>Ces désavantages sont des défauts d'incarnation.</p>
		<?php
		$avdesav_list = $repo_avdesav->getAvDesavByCategory("In Nomine");
		$avdesav_list = array_filter($avdesav_list, fn($avdesav) => !in_array($avdesav->id, [165, 166]));
		foreach ($avdesav_list as $avdesav) {
			$avdesav->displayInRules();
		}
		?>

	</details>

	<!-- Compétences -->
	<details>
		<summary>
			<h3>Compétences</h3>
		</summary>
		<p>Certains anges et démons se sont déjà incarnés sur Terre dans le passé. Ils ont eu l’occasion d'apprendre des compétences variées qu'ils maîtrisent encore au cours de leurs incarnations ultérieures. Les compétences «&nbsp;récentes&nbsp;» telles que l’informatique sont rarement maîtrisées par les personnages au moment de leur incarnation, mais ils sont tout à fait capables de les développer. Ainsi, la liberté de choix de compétences pour les personnages est très grande.</p>
		<p>
			<b>• Projection magique&nbsp;:</b> toucher sa cible avec un pouvoir d’<i>Attaque à distance</i>. Il s'agit de la compétence <i>Lancer de sort</i> renommée pour l’occasion.<br>
			<b>• Langues&nbsp;:</b> les anges et démons maîtrisent toutes les langues parlées par l’Humanité depuis 3761 av. J.C. comme si c’était leur langue maternelle (Int +5). Ils parlent égalemant le <i>langage angélique</i> (sorte de gazouilli elfique ethéré) ou le <i>langage démonique</i> (langue sombre et rocailleuse).
		</p>
	</details>

	<!-- Serviteurs & familiers -->
	<details>
		<summary>
			<h3>Serviteurs &amp; Familiers</h3>
		</summary>
		Les anges et les démons peuvent avoir des serviteurs sous leurs ordres. Ce sont des <i>Serviteurs de Dieu</i> pour les anges et des <i>Familiers</i> pour les démons.
		<h4>Serviteurs de Dieu</h4>
		<p>Ce sont des humains au courant du <i>Grand Jeu</i> et totalement dévoués aux forces du Bien.</p>
		<p><b>• Investigateur (10 pts)&nbsp;:</b> toujours disponible.<br>
			<b>• Serviteur spécialisé (5 pts)&nbsp;:</b> informaticien, avocat, comptable, commissaire de police, militaire, éditeur, etc. Disponible selon son emploi du temps professionnel.
		</p>

		<h4>Familiers</h4>
		<p>Les familiers sont des animaux ou des objets au service de leur maître. Le plus souvent dociles, ils peuvent cependant devenir mesquins et sont aigris de ne plus être un démon à part entière. 50 pts de personnage dans 3 pouvoirs maximum à la création (à 25 pts au maximum). Un <i>Familier</i> coûte 15 pts de personnage et est considéré, en termes de règles comme un <i>Serviteur</i>.</p>
		<p><b>• Animal&nbsp;:</b> intelligence humaine, tout le reste identique à un individu normal. +50% PdV. Doué de parole.<br>
			<b>• Objet&nbsp;:</b> intelligence humaine. +5 à l’<i>Intégrité</i>. Doué de parole.
		</p>
		<p><b>Amélioration des familiers&nbsp;:</b> un familier peut bénéficier de nouveaux pouvoirs ou améliorer ses compétences dans un pouvoir. Pour cela, son maître doit avoir réussi un mission à laquelle le familier a participé. Le maître du familier doit dépenser la moitié des points de personnage servant à améliorer les pouvoirs du familier. Le familier ne peut dépenser plus de points de personnage que son maître n’en a reçus au cours d’une mission. Il ne peut pas non plus les cumuler.</p>
	</details>

</article>

<!-- Archanges & Princes-Démons -->
<article>
	<h2>Archanges &amp; Princes-démons</h2>

	<!-- Généralités -->
	<details>
		<summary>
			<h3>Généralités</h3>
		</summary>
		<p>Les Archanges et les Princes-Démons peuvent s’incarner à volonté sur Terre. Ce sont eux qui dirigent les forces du Bien et du Mal.</p>
	</details>

	<!-- Archanges -->
	<details>
		<summary>
			<h3>Archanges</h3>
		</summary>

		<p>Voir le <i>Scriptarium Veritas</i> pour plus de détails sur l’histoire et la personalité de chaque Archange.</p>
		<ul>
			<li>Alain, Archange des Cultures</li>
			<li>Ange, Archange des Convertis</li>
			<li>Blandine, Archange des Rêves</li>
			<li>Christophe, Archange des Enfants</li>
			<li>Daniel, Archange de la Pierre</li>
			<li>Didier, Archange de la Communication</li>
			<li>Dominique, Archange de la Justice</li>
			<li>Francis, Archange de la Diplomatie</li>
			<li>Guy, Archange des Guérisseurs</li>
			<li>Janus, Archange des Vents</li>
			<li>Jean, Archange de la Foudre</li>
			<li>Jean-Luc, Archange des Protecteurs</li>
			<li>Jordi, Archange des Animaux</li>
			<li>Joseph, Archange de l’Inquisition</li>
			<li>Laurent, Archange de l’Épée</li>
			<li>Marc, Archange des Échanges</li>
			<li>Mathias, Archange de la Confusion</li>
			<li>Michel, Archange de la Guerre</li>
			<li>Novalis, Archanges des Fleurs</li>
			<li>Walther, Archange des exorcistes</li>
			<li>Yves, Archange des Sources</li>
		</ul>

	</details>

	<!-- Princes-démons -->
	<details>
		<summary>
			<h3>Princes-démons</h3>
		</summary>

		<p>Voir le <i>Scriptarium Veritas</i> pour plus de détails sur l’histoire et la personalité de chaque Prince-démon.</p>
		<ul>
			<li>Abalam, Prince de le Folie</li>
			<li>Andrealphus, Prince du Sexe</li>
			<li>Andromalius, Prince du Jugement</li>
			<li>Asmodée, Prince du Jeu</li>
			<li>Baal, Prince de la Guerre</li>
			<li>Baalberith, Prince des Messagers</li>
			<li>Beleth, Prince des Cauchemars</li>
			<li>Bélial, Prince du Feu</li>
			<li>Bifrons, Prince des Morts</li>
			<li>Caym, Prince des Animaux</li>
			<li>Crocell, Prince du Froid</li>
			<li>Furfur, Prince du Hardcore</li>
			<li>Gaziel, Prince de la Terre</li>
			<li>Haagenti, Prince de la Gourmandise</li>
			<li>Kobal, Prince de l’Humour Noir</li>
			<li>Kronos, Prince de l’Éternité</li>
			<li>Malphas, Prince de la Discorde</li>
			<li>Malthus, Prince des Maladies</li>
			<li>Mammon, Prince de la Cupidité</li>
			<li>Morax, Prince des Dons artistiques</li>
			<li>Nisroch, Prince des Drogues</li>
			<li>Nybbas, Prince des Médias</li>
			<li>Ouikka, Prince des Airs</li>
			<li>Samigina, Prince des Vampires</li>
			<li>Scox, Prince des Âmes</li>
			<li>Shaytan, Prince de la Laideur</li>
			<li>Uphir, Prince de la Pollution</li>
			<li>Valefor, Prince des Voleurs</li>
			<li>Vapula, Prince de la Technologie</li>
			<li>Véphar, Prince des Océans</li>
		</ul>

	</details>

</article>

<!-- Pouvoirs -->
<article>
	<h2>Pouvoirs</h2>

	<!-- Généralités -->
	<details>
		<summary>
			<h3>Règles générales sur les pouvoirs</h3>
		</summary>

		<p>Un personnage débutant choisit 3 ou 4 pouvoirs au maximum.</p>

		<h4>Types de pouvoirs</h4>
		<p>Il existe deux catégories de pouvoirs.</p>
		<p><b>• Les pouvoirs de type <i>Avantage surnaturel</i>&nbsp;:</b> repérés par une astérisque, ils sont permanents, ne coûtent aucun PdM et ne nécessitent aucun jet de réussite.</p>
		<p><b>• Les pouvoirs de type <i>Sort</i>&nbsp;:</b> ils fonctionnent comme des sorts. Un jet de réussite est donc nécessaire pour les déclencher et ils impliquent une dépense de PdM.</p>

		<h4>Pouvoirs spéciaux</h4>
		<p>Les <i>Pouvoirs spéciaux</i> peuvent être acquis seulement s’ils sont en lien <i>direct</i> avec la sphère d’influence du supérieur du personnage. C'est l'équivalent des pouvoirs spécifiques dans la version originale du jeu.</p>

		<h4>Fonctionnement des pouvoirs de type <i>Sort</i></h4>
		<p>Ces pouvoirs fonctionnent comme décrit dans les RdB, à l'exception des points détaillés ci-dessous.</p>
		<p>
			<b>• Temps nécessaire &amp; rituel&nbsp;:</b> sauf indication contraire, tous les pouvoirs dont le <i>Temps nécessaire</i> est <i>court</i> se déclenchent de manière instantanée et sans rituel. Le personnage doit juste se concentrer.<br>
			Si le <i>Temps nécessaire</i> est <i>long</i>, suivre les règles générales concernant les sorts.<br>
			Dans tous les cas, un seul pouvoir peut être déclenché par seconde.
		</p>
		<p><b>• Coût énergétique&nbsp;:</b> <i>demi-coût pour les lancer</i>. Coût identique pour le maintien. Un échec coûte autant de PdM qu’une réussite.</p>
		<p><b>• Sujet d’un pouvoir&nbsp;:</b> lorsqu’un pouvoir affecte les êtres humains, il affecte aussi toutes les créatures incarnées dans des corps humains. Les pouvoirs défensifs ne peuvent agir que sur leur initiateur.</p>

		<h4>Récupération de PdM</h4>
		<p>Anges ou démons&nbsp;: 1 PdM / 2 heures.<br>
			Ce rythme est doublé si le personnage fait quelque chose en relation avec le domaine de prédilection de son Archange.</p>
		<p>Familier&nbsp;: 1 PdM / 4 heures.</p>

	</details>

	<?php
	$categories = $repo_powers->getDistinctCategories("ins");
	?>

	<!-- Pouvoirs d’anges -->
	<details>
		<summary>
			<h3>
				<?php if ($_SESSION["Statut"] == 3) { ?><a href="gestion-listes?req=pouvoir&id=0" class="edit-link ff-far">&#xf044;</a><?php } ?>
				Pouvoirs d’Anges
			</h3>
		</summary>
		<?php
		foreach ($categories as $categorie) {
			$pouvoirs = $repo_powers->getPowersByCategories("ins", $categorie);
			$pouvoirs_anges = array_filter($pouvoirs, fn($x) => $x->specific["Domaine"] !== "Démon");
			$pouvoirs_anges = Sorter::sortPowersByName($pouvoirs_anges);
		?>
			<h4><?= $categorie ?></h4>
			<div>
				<?php foreach ($pouvoirs_anges as $pouvoir) {
					$pouvoir->displayInRules(show_edit_link: $_SESSION["Statut"] === 3);
				} ?>
			</div>
		<?php } ?>
	</details>

	<!-- Pouvoirs de démons -->
	<details>
		<summary>
			<h3>
				<?php if ($_SESSION["Statut"] == 3) { ?><a href="gestion-listes?req=pouvoir&id=0" class="edit-link ff-far">&#xf044;</a><?php } ?>
				Pouvoirs de Démons
			</h3>
		</summary>
		<?php
		foreach ($categories as $categorie) {
			$pouvoirs = $repo_powers->getPowersByCategories("ins", $categorie);
			$pouvoirs_demons = array_filter($pouvoirs, fn($x) => $x->specific["Domaine"] !== "Ange");
			$pouvoirs_demons = Sorter::sortPowersByName($pouvoirs_demons);
		?>
			<h4><?= $categorie ?></h4>
			<div>
				<?php foreach ($pouvoirs_demons as $pouvoir) {
					$pouvoir->displayInRules(show_edit_link: $_SESSION["Statut"] === 3);
				} ?>
			</div>
		<?php } ?>
	</details>

</article>

<!-- Vie des anges & démons -->
<article>
	<h2>Vie des anges &amp; démons</h2>

	<details>
		<summary>
			<h3>Incarnation</h3>
		</summary>
		<p>Les anges et démons s’incarnent dans un corps «&nbsp;créé&nbsp;» pour l’occasion. Il peut arriver, de manière exceptionnelle, qu’ils s’incarnent dans le corps d’un être humain qui vient de mourir, toujours dans un but bien précis.</p>
		<p>Un ange ou un démon nouvellement incarné n’a donc aucune identité officielle. Il s’incarne nu dans un endroit approprié (à la manière de <i>Terminator</i>). Le corps présente des traits lui permettant de passer pour un natif de la région où il s’est incarné.</p>
		<p>Ces corps ne vieillissent pas, ce qui peut obliger un ange ou un démon incarné depuis un certain temps à changer d’identité pour éviter d’éveiller les soupçons.</p>
	</details>

	<details>
		<summary>
			<h3>Souvenirs</h3>
		</summary>
		<p>Au moment de leur incarnation, anges et démons ne se souviennent de rien. Ni de leurs éventuelles précédentes incarnations (le <i>Grand Jeu</i> a commencé après la mort du Christ), ni de leur vie au Paradis ou en Enfer. Ces souvenirs peuvent revenir par bribe au cours du temps, dans des circonstances exceptionnelles (sur un 111 ou un 666 lors d’un jet de dés, ou après une expérience traumatisante ou un stress intense).</p>
	</details>

	<details>
		<summary>
			<h3>Grades</h3>
		</summary>
		<p>Le <i>Grade 1</i> est obtenu dès que l’ange ou le démon réussit correctement une mission.</p>
		<p>Le <i>Grade 2</i> est obtenu dès que l’ange ou le démon possède 2 pouvoirs de niveau IV et 10 PdM supplémentaires.</p>
		<p>Le <i>Grade 3</i> est obtenu lors d’une action particulièrement éclatante ou d’une mission particulièrement réussie.</p>
	</details>

	<details>
		<summary>
			<h3>Mort</h3>
		</summary>
		<p>Lorsqu’un ange ou un démon meurt, son corps disparaît dans un petit «&nbsp;pops&nbsp;» sonore (sauf s’il s’est incarné dans un corps humain déjà existant). Ceci est également vrai pour toutes ses parties, y compris son sang, ainsi que tout ce qu’il portait. Le personnage retourne au Paradis ou en Enfer, jusqu'à une nouvelle incarnation.</p>
	</details>

</article>

<!-- Pour le MJ -->
<article>
	<h2>Pour le MJ</h2>

	<details>
		<summary>
			<h3>Missions &amp; points de personnage</h3>
		</summary>
		<p>À <i>In Nomine</i>, les points de personnage sont divisés en deux groupes&nbsp;:</p>
		<ul>
			<li>Les points classiques, servant à quantifier l’expérience acquise&nbsp;;</li>
			<li>Les points de «&nbsp;récompense&nbsp;» si la mission est réussie (10 à 15 pts pour une mission «&nbsp;classique&nbsp;»).</li>
		</ul>
		<p>Les points acquis grâce à l’expérience peuvent servir à tout, sauf à acquérir un nouveau pouvoir ou à augmenter le niveau de puissance d’un pouvoir (mais ils peuvent servir à améliorer le <i>score</i> d’un pouvoir).</p>
		<p>Les points de récompense ne peuvent servir qu’à l’acquisition d’un nouveau pouvoir ou à l’augmentation du niveau de puissance d’un pouvoir.</p>
	</details>

	<details>
		<summary>
			<h3>Organisation des forces du Bien</h3>
		</summary>
		<p>Les anges nouvellement incarnés sont contactés par un ange déjà incarné appartenant à un QG des forces du Bien. Il existe plusieurs QG dans le monde, mais pas dans tous les pays. Un QG rassemble quelques anges haut-gradés plus quelques humains dans la confidence du <i>Grand Jeu</i>. Ces QG sont des bureaux secrets disposant d’une technologie de pointe et de moyens financiers très importants.</p>
		<p>Les missions des démons ont un des objectifs généraux suivants&nbsp;:</p>
		<ul>
			<li>Éliminer des Démons qui ont été repérés&nbsp;;</li>
			<li>Enquêter sur la disparition d’Anges lorsque leur mort n’a pas été clairement établie&nbsp;;</li>
			<li>Veiller à la préservation du <i>Principe de Discrétion</i>&nbsp;;</li>
			<li>Pourchasser les renégâts et les sorciers (et tous ceux qui se mettent en travers du plan divin)&nbsp;;</li>
			<li>Contrecarrer les plans des Forces du Mal&nbsp;;</li>
			<li>S’assurer que l’Humanité ne cède pas à l’influence du Malin&nbsp;;</li>
			<li>Infiltrer les organisations humaines pour faciliter l’action des Anges&nbsp;;</li>
			<li>Procurer des moyens financiers importants aux Forces du Bien.</li>
		</ul>

		<h4>Soldats de Dieu</h4>
		<p>Ce sont des humains au courant du Grand Jeu et qui ont un entraînement militaire poussé. Ils ne disposent cependant pas de pouvoirs.</p>
	</details>

	<details>
		<summary>
			<h3>Organisation des forces du Mal</h3>
		</summary>
		<p>Les forces du Mal sont organisées à la manière de cellules terroristes&nbsp;: un démon de grade 3 gère un ou plusieurs groupes de démons. Il leur attribue des missions et s’occupe des différents aspects administratifs de ses subordonnés.<br>
			Un démon nouvellement incarné est accueilli par un «&nbsp;parrain&nbsp;» qui se charge de lui donner des vêtements et le minimum vital pour s’insérer dans la société sans se faire remarquer.</p>
		<p>Les missions des démons ont un des objectifs généraux suivants&nbsp;:</p>
		<ul>
			<li>Éliminer des Anges qui ont été repérés&nbsp;;</li>
			<li>Enquêter sur la disparition de démons lorsque leur mort n’a pas été clairement établie&nbsp;;</li>
			<li>Veiller à la préservation du <i>Principe de Discrétion</i>&nbsp;;</li>
			<li>Pourchasser les renégâts et les sorciers&nbsp;;</li>
			<li>Contrecarrer les plans des Forces du Bien&nbsp;;</li>
			<li>S’assurer que l’Humanité laisse libre cours à ses pulsions naturelles&nbsp;;</li>
			<li>Infiltrer les organisations humaines pour faciliter l’action des démons&nbsp;;</li>
			<li>Procurer des moyens financiers importants aux Forces du Mal.</li>
		</ul>

		<h4>Relation entre l’Enfer et les démons sur Terre</h4>
		<p>Les Prince-Démons peuvent s’incarner à volonté sur Terre, mais ils ne le font que dans des affaires importantes. Ils peuvent également envoyer des messages à leurs serviteurs.</p>

	</details>

	<details>
		<summary>
			<h3>Monde des rêves</h3>
		</summary>
		<p>Une personne en train de rêver de manière naturelle est généralement seule dans son rêve. L’utilisation d’un pouvoir de rêve (<i>Rêve</i> ou <i>Cauchemar</i>) permet de pénétrer dans le rêve de la cible.</p>
		<p>Lorsqu’un personnage tente de rejoindre un rêve, le <i>Maître du rêve</i> peut tenter de s’y opposer. Faire un duel de compétence en pouvoir de rêve (ou <i>Volonté</i>, selon le plus avantageux).</p>

		<h4>Efficacité dans le monde des rêves</h4>
		<p>La manière d’entrer dans le rêve influera sur la puissance et la liberté d’action du personnage. Ceci est simulé par l’Efficacité dans le Monde des Rêves (EMR).</p>
		<table class="left-1">
			<tr>
				<th>Rêveur</th>
				<th>EMR</th>
			</tr>
			<tr>
				<td>Rêve naturel</td>
				<td>1</td>
			</tr>
			<tr>
				<td>Rêve induit par un pouvoir</td>
				<td>1 ou 2*</td>
			</tr>

			<tr>
				<th>Initiateur d’un pouvoir</th>
				<th>EMR</th>
			</tr>
			<tr>
				<td><i>Rêve</i> ou <i>Cauchemar</i></td>
				<td>2</td>
			</tr>
			<tr>
				<td><i>Rêve divin</i> ou <i>Cauchemar mortel</i></td>
				<td>3</td>
			</tr>
		</table>
		<p>* Au choix de l’initiateur du pouvoir.</p>

		<h4>Maître du rêve</h4>
		<p>Le <i>Potentiel de création</i> d’un rêveur vaut (Vol/2 + PdM)×EMR. Les PdM sont ceux dont dispose le personnage sur le moment.</p>
		<p>Le personnage dont le <i>Potentiel de création</i> est le plus élevé dirige le rêve. Il est maître du décor, mais pas des actions des autres personnage inclus dans le rêve.</p>

		<h4>Actions</h4>
		<p>•&nbsp;<b>Déplacement&nbsp;:</b> <i>Vitesse</i> × EMR</p>
		<p>•&nbsp;<b>Actions physiques&nbsp;:</b> les actions impliquant la <i>For</i>, la <i>San</i> et/ou la <i>Dex</i> subissent un modificateur égal à <i>Volonté</i> &ndash; moyenne(<i>For</i>, <i>San</i> <i>Dex</i>). Ce modificateur s'applique également aux dégâts calculés à partir de la <i>For</i>.</p>
		<p>•&nbsp;<b>Actions mentales&nbsp;</b> elles fonctionnent comme dans le monde réel.</p>
		<p>•&nbsp;<b>Bonus d’EMR&nbsp;:</b> une EMR de 3 apportent un bonus de +2 à tous les jets et aux dégâts.</p>

		<h4>Dégâts</h4>
		<p>Les dégâts causés dans le monde des rêves peuvent être retirés aux PdV ou aux PdM de la victime, au choix de l’attaquant. Ces dégâts ne sont pas réels (sauf la perte de PdM). Lorsque les PdV ou les PdM d’un participant arrivent à 0, il se réveille et ne peut plus rentrer dans le rêve avant 2h.</p>

		<h4>Spécificité des divers pouvoirs</h4>
		<p>Un personnage entré dans un rêve grâce au pouvoir <i>Cauchemar mortel</i> inflige des dégâts réels à sa victime et cette dernière peut mourir. Le possesseur de ce pouvoir peut également infliger des dégâts réels (et donc décomptés des PdV) à n’importe quel personnage entré dans le rêve pour 1 PdM à chaque fois.</p>
		<p>Un personnage entré dans un rêve avec le pouvoir <i>Rêve</i> peut à tout moment connaître la position de sa victime et son état (PdV et PdM).</p>
		<p>Un personnage entré dans un rêve avec le pouvoir <i>Cauchemar</i> ou <i>Cauchemar mortel</i> peut réveiller la victime en gagnant un duel de <i>Volonté</i> contre elle (le score de pouvoir peut être utilisé à la place de la <i>Volonté</i> s’il est meilleur). Si la victime se réveille, le rêve s’arrête et tous les protagonistes se réveillent.</p>
		<p>Le pouvoir <i>Rêve divin</i> permet à son utilisateur de connaître les intentions, la position de sa victime et son état (PdV et PdM). Pour 2 PdM, il peut obtenir les mêmes renseignements sur un autre occupant du rêve.</p>

	</details>

	<details>
		<summary>
			<h3>Advanced Clochers &amp; Cathédrales</h3>
		</summary>
		<p>Les églises bénéficient de grades comme les anges. Le grade d’une église dépend de sa taille, de son ancienneté, de sa fréquentation et éventuellement d’événements exceptionnels qui se seraient passés en son sein.</p>

		<h4>Pouvoirs</h4>
		<p>Les églises possèdent [Grade+1] pouvoirs, identiques à ceux des anges, à choisir de manière cohérente. Elles ont entre 5 et 50 PdM, qu’elles récupèrent à une vitesse comprise entre 2 et 10 PdM par 24 h. En plus de ces pouvoirs, les églises disposent de pouvoirs liés à leur grade&nbsp;:</p>
		<p>
			Grade 1&nbsp;: <i>Détection du mal</i> automatique dans son enceinte.<br>
			Grade 2&nbsp;: <i>Détection du mal</i> automatique hors de son enceinte (portée de 30 m).<br>
			Grade 3&nbsp;: permet de créer de l’eau bénite à volonté et d’en remplir ses bénitiers.
		</p>
		<p>À part les pouvoirs possédés par l’édifice et dont elle se sert pour défendre les chrétiens qui l’occupent en cas de danger, elle offre aussi une protection mentale pour ceux qui croient en Dieu et qui ont confiance en sa force (+2 à +6 aux jets de résistance).</p>

	</details>

</article>