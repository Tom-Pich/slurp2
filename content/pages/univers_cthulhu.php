<?php

use App\Repository\SkillRepository;

$repo_skills = new SkillRepository;
?>

<!-- Personnages -->
<article class="as-start">
	<h2>Personnages</h2>

	<details>
		<summary>
			<h3>Points de personnage</h3>
		</summary>
		<p><b>Investigateur débutant&nbsp;:</b> 80 à 100 pts</p>
	</details>

	<details>
		<summary>
			<h3>Avantages &amp; désavantages</h3>
		</summary>
		<p><b>• Alphabétisation :</b> entre 0 (<i>Alphabétisé</i>) et -10 pts (<i>Illettré</i>).</p>
		<p><b>• Magerie (5 pts / niv) :</b> +1 par niveau pour lancer des sorts. Permet également de savoir si un objet touché est magique.</p>
		<p><b>• Richesse de base :</b> 750 $ pour les États-Unis de 1920. Le personnage dispose généralement de 20 % de sa richesse de base sous forme de liquidité (compte en banque ou autre).<br />
			Salaire mensuel moyen&nbsp;: 100 $.<br />
			Coût de la vie : 70 $ pour un <i>Statut social</i> de 0.</p>
	</details>

	<details>
		<summary>
			<h3>Compétences</h3>
		</summary>
		<?php
		$skill_cthulhu = $repo_skills->getSkill(197);
		$skill_cthulhu->displayInRules();
		?>
	</details>

</article>

<!-- Magie -->
<article class="as-start">
	<h2>Magie</h2>

	<details>
		<summary>
			<h3>Généralités</h3>
		</summary>
		<p>La magie de Chtulhu est une magie étrange, dangereuse et chaotique qui ne suit pas les règles standards.</p>
		<p>Utiliser la magie ne nécessite pas l’avantage <i>Magerie</i> (mais ce dernier facilite sa pratique).</p>
	</details>

	<details>
		<summary>
			<h3>Lancer un sort</h3>
		</summary>
		<p>La description d’un sort contient tous les renseignements nécessaires.</p>
		<p>Lancer un sort est généralement dommageable pour la santé mentale du sorcier. Cela nécessite souvent un rituel long et compliqué, ainsi que des composantes matérielles et/ou des conditions particulières. Il peut parfois être nécessaire de sacrifier définitivement un ou plusieurs points de <i>Volonté</i> et/ou PdE pour pouvoir lancer un sort. La plupart des sorts ont un coût énergétique élevé.</p>
		<p>Les sorts ne s’apprennent pas&nbsp;: les chances de succès pour les lancer dépendent, entre autres, du nombre de PdM investis dans le sort. Un jet de 16 est toujours un échec.</p>
	</details>

</article>

<!-- Grimoires -->
<article class="as-start">
	<h2>Grimoires</h2>

	<details>
		<summary>
			<h3>Caractéristiques</h3>
		</summary>
		<p>Chaque grimoire a deux caractéristiques chiffrées :</p>
		<p><b>• Contenu (de 1 à 10) :</b> indique la quantité d’informations sur le Mythe.</p>
		<p><b>• Clarté (de 0 à -5) :</b> indépendamment de son contenu, un ouvrage peut être rédigé et/ou traduit de manière plus ou moins claire.</p>
	</details>

	<details>
		<summary>
			<h3>Lecture d’un grimoire</h3>
		</summary>
		<h4>Lecture superficielle</h4>
		<p>Parcourir un ouvrage du Mythe afin de savoir de quoi il traite et quels types de sortilèges il contient. La lecture superficielle d’un grimoire prend une heure pour 10 à 100 pages.</p>
		<p>- jet de <i>Langue</i> ou d'<i>Int</i> (plus faible) modifié par sa <i>Clarté</i> pour comprendre de quoi parle le livre.</p>
		<p>- Perte de PdE égale à un quart du <i>Contenu</i> (moitié de cette valeur si un jet de <i>Sang-froid</i> est réussi). Le joueur devra prendre note de cette perte car elle sera déduite des PdE perdus en cas de lecture complète.</p>
		<p>Une lecture superficielle ne peut faire gagner de points en <i>Mythe de Cthulhu</i>. Le lecteur aura une idée de son contenu ainsi que des sorts décrits.</p>

		<h4>Lecture approfondie</h4>
		<p>L’étude d’un ouvrage du Mythe permet de gagner autant de points en <i>Mythe de Cthulhu</i> que le score de <i>Contenu</i> du livre. Chaque point nécessite une étude d’une vingtaine d’heures et la réussite d’un jet de <i>Langue</i> ou d’<i>Int</i> (le plus faible des deux) modifié par la <i>Clarté</i> du livre.</p>
		<p>Lorsque le personnage a étudié la moitié du livre, il doit faire un jet de <i>Sang-froid</i> avec un malus égal à la moitié de son score de <i>Contenu</i>. En cas d’échec, il perd autant de PdE que de pts gagnés en Mythe de Cthulhu (la moitié en cas de réussite). Lorsqu’il a fini d’étudier le livre, il faut refaire un tel jet, avec les mêmes conséquences.</p>

		<h4>Trouver une information</h4>
		<p>Pour déterminer si une information donnée se trouve dans un grimoire, faire un jet sous <i>Contenu</i>×2 (avec 3d), assorti d’un modificateur qui dépend de la spécificité de l’information recherchée. Si le jet est réussi, l’information est présente.<br />
			Le lecteur doit réussir des jets de <i>Recherches</i> s’il a déjà lu le grimoire (au moins superficiellement) pour la trouver.</p>
	</details>

	<details>
		<summary>
			<h3>Apprentissage des sorts</h3>
		</summary>
		<p>Certains grimoires contiennent des sorts. Pour comprendre un sort (et donc pouvoir essayer de le lancer), il faut réussir un jet d’<i>Int</i> + <i>Magerie</i> + <i>Clarté</i> de l’ouvrage.</p>
	</details>

</article>