<?php

use App\Lib\Sorter;
use App\Repository\AvDesavRepository;
use App\Repository\PowerRepository;

$repo_avdesav = new AvDesavRepository;
$repo_powers = new PowerRepository("ins");

?>

<article>
	<h2>Personnage</h2>

	<details>
		<summary class="h3">Points de personnage</summary>
		<p><b>Personnage débutant&nbsp;:</b> 230 pts (anges) ou 220 pts (démons)</p>
		<ul>
			<li><b>Caractéristiques&nbsp;:</b> 100 à 130 pts</li>
			<li><b>Avantages &amp; désavantages&nbsp;:</b> -10 à 10 pts</li>
			<li><b>Compétences&nbsp;:</b> 15 à 30 pts</li>
			<li><b>Pouvoirs&nbsp;:</b> 40 à 70 pts</li>
		</ul>
	</details>

	<details>
		<summary class="h3">Incarnation &amp; supérieur</summary>
		<p>Les anges et démons s’incarnent dans un corps humain <b>créé</b> pour l’occasion (contrairement à la version officielle du jeu).</p>
		<p>Chaque ange ou démon est affilié à un <i>Archange</i> ou à un <i>Prince-Démon</i>. Ce choix va guider la création du personnage et sa philosophie une fois incarné.</p>
	</details>

	<details>
		<summary class="h3">Avantages &amp; Désavantages</summary>
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
		$avdesav_list = $repo_avdesav->getAvDesavByCategory("INS");
		$avdesav_list = array_filter($avdesav_list, fn ($avdesav) => !in_array($avdesav->id, [165, 166]));
		foreach ($avdesav_list as $avdesav) {
			$avdesav->displayInRules();
		}
		?>

	</details>

	<details>
		<summary class="h3">Compétences</summary>
		<p>Certains anges et démons se sont déjà incarnés sur Terre dans le passé. Ils ont eu l’occasion d'apprendre des compétences variées qu'ils maîtrisent encore au cours de leurs incarnations ultérieures. Les compétences «&nbsp;récentes&nbsp;» telles que l’informatique sont rarement maîtrisées par les personnages au moment de leur incarnation, mais ils sont tout à fait capables de les développer. Ainsi, la liberté de choix de compétences pour les personnages est très grande.</p>
		<p>
			<b>• Projection magique&nbsp;:</b> toucher sa cible avec un pouvoir d’<i>Attaque à distance</i>. Il s'agit de la compétence <i>Lancer de sort</i> renommée pour l’occasion.<br>
			<b>• Langues&nbsp;:</b> les anges et démons maîtrisent toutes les langues parlées par l’Humanité depuis 3761 av. J.C. comme si c’était leur langue maternelle (Int +5). Ils parlent égalemant le <i>langage angélique</i> (sorte de gazouilli elfique ethéré) ou le <i>langage démonique</i> (langue sombre et rocailleuse).
		</p>
	</details>

	<details>
		<summary class="h3">Serviteurs &amp; Familiers</summary>
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

<article>
	<h2>Archanges &amp; Princes-démons</h2>

	<details>
		<summary class="h3">Généralités</summary>
		<p>Les Archanges et les Princes-Démons peuvent s’incarner à volonté sur Terre. Ce sont eux qui dirigent les forces du Bien et du Mal.</p>
	</details>

	<details>
		<summary class="h3">Archanges</summary>

		<details class="liste">
			<summary class="clr-grey-500"><div><b>Alain</b>, Archange des Cultures</div></summary>
		</details>

		<details class="liste">
			<summary class="clr-grey-500"><div><b>Ange</b>, Archange des Convertis</div></summary>
		</details>

		<details class="liste">
			<summary>
				<div><b>Blandine</b>, Archange des Rêves</div>
			</summary>
			<p>cet Archange apparaît sur terre sous forme d'une femme dotée d'une beauté qui n'est égalée que par la Miséricorde de Dieu. Elle arrive ainsi à s'introduire dans les plus hauts milieux politiques. Elle délivre un message divin en entrant la nuit dans les chambres afin d'introduire une fausse mémoire dans le cerveau de la personnalité de son choix. Blandine est envoyée auprès des Démons les plus puissants afin d'obtenir malgré eux des informations et de remplacer certaines idées et souvenirs. Blandine n'évolue que rarement parmi les Anges de bas rang et les méprise d’ailleurs un peu.</p>
		</details>

		<details class="liste">
			<summary class="clr-grey-500"><div><b>Christophe</b>, Archange des Enfants</div></summary>
		</details>

		<details class="liste">
			<summary class="clr-grey-500"><div><b>Daniel</b>, Archange de la Pierre</div></summary>
		</details>

		<details class="liste">
			<summary class="clr-grey-500"><div><b>Didier</b>, Archange de la Communication</div></summary>
		</details>

		<details class="liste">
			<summary class="clr-grey-500"><div><b>Dominique</b>, Archange de la Justice</div></summary>
		</details>

		<details class="liste">
			<summary>
				<div><b>Francis</b>, Archange de la Diplomatie</div>
			</summary>
			<p>Francis est, tout comme Didier, hypocrite et menteur, mais c’est toujours pour la bonne cause. Son but est de régler politiquement tous les conflits. Dieu accorde toute sa confiance à Francis. Il est aux humains ce que Didier est aux Anges : un conciliateur, un diplomate et un beau parleur. Il est aussi l’antithèse de Malphas, et on le trouve souvent en opposition à ce Prince-Démon lors de missions dans les milieux de la politique internationale.</p>
		</details>

		<details class="liste">
			<summary>
				<div><b>Guy</b>, Archange des Guérisseurs</div>
			</summary>
			<p>Guy apparaît le plus souvent sous la forme d'un homme en blanc. Il est très serviable et toujours prêt à aider son prochain surtout si celui-ci est blessé. Malgré tout, il n'aime pas se faire marcher sur les pieds et est un peu le rebelle du conseil défensif. Toujours sur le qui-vive, il n'hésite jamais à dénoncer à Dieu les erreurs des membres des forces du Bien qu'il aime le moins (Laurent, Michel et tous les autres membres du conseil offensif). Dieu place des Anges de Guy partout où les êtres humains souffrent (pays en guerre, lieux de tremblements de terre etc...). Ils font toujours leur travail mais ressentent assez mal la violence causée par certains Anges ou organisations divines (skins, milices chrétiennes etc&hellip;).</p>
		</details>

		<details class="liste">
			<summary>
				<div><b>Janus</b>, Archange des Vents</div>
			</summary>
			<p>
				Janus est plutôt critiqué dans le milieu divian, mais d’après Dieu il faut les choses très bien : il vole aux FOrces du mal énormément d’argent, puis le redistribue aux divers organismes humanitaires sous couvert d’une personnalité.<br>
				Sur Terre, il opère à partir d’hôtels de luxe et fait des raids dans les places les mieux gardées de la planète.<br>
				Janus évite du mieux qu’il le peut les combats, car il ne supporte pas d’avoir à tuer. Il est, paraît-il, un grand ami de Jean, l’Archange de la Foudre.
			</p>
		</details>
		
		<details class="liste">
			<summary class="clr-grey-500"><div><b>Jean</b>, Archange de la Foudre</div></summary>
		</details>

		<details class="liste">
			<summary>
				<div><b>Jean-Luc</b>, Archange des Protecteurs</div>
			</summary>
			<p>Jean-Luc est très sympathique de prime abord et est d’un altruisme qui frôle souvent le masochisme. Il est presque suicidaire et, lorsqu’il protège quelqu’un, ne pense jamais aux conséquences. Dieu accord une grande importance à Jean-Luc et à ses serviteurs. Il sait qu’il peut compter sur eux en toutes occasions. Jean-Luc n’est jamais responsable d’une mission en particulier mais ses serviteurs sont présents dans presque tous les pays du monde et dans la plupart des groupes d’Anges investigateurs.</p>
		</details>
		
		
		<details class="liste">
			<summary class="clr-grey-500"><div><b>Jordi</b>, Archange des Animaux</div></summary>
		</details>
		
		<details class="liste">
			<summary class="clr-grey-500"><div><b>Joseph</b>, Archange de l’Inquisition</div></summary>
		</details>

		<details class="liste">
			<summary>
				<div><b>Laurent</b>, Archange de l’Épée</div>
			</summary>
			<p>Laurent est le chef suprême des armées divines sur Terre, et il fait ça très bien. Il coordonne les missions et déplacements des Anges possédants des Soldats et rend compte à Dieu des résultats. Il dirige ses troupes avec une grande habilité. Laurent est bonhomme et un peu naïf quant aux malheurs du monde.</p>
		</details>
		
		<details class="liste">
			<summary class="clr-grey-500"><div><b>Marc</b>, Archange des Échanges</div></summary>
		</details>
		
		<details class="liste">
			<summary class="clr-grey-500"><div><b>Mathias</b>, Archange de la Confusion</div></summary>
		</details>
		
		<details class="liste">
			<summary class="clr-grey-500"><div><b>Michel</b>, Archange de la Guerre</div></summary>
		</details>
		
		<details class="liste">
			<summary class="clr-grey-500"><div>Novalis</b>, Archanges des Fleurs</div></summary>
		</details>
		
		<details class="liste">
			<summary class="clr-grey-500"><div><b>Walther</b>, Archange des exorcistes</div></summary>
		</details>

		<details class="liste">
			<summary>
				<div><b>Yves</b>, Archange des Sources</div>
			</summary>
			<p>Yves est aux côtés de Dieu depuis la création de la Terre. Il n'intervient qu'extrêmement rarement sur terre, et passe le plus clair de son temps à méditer. La légende dit que c'est lui qui a eu l'idée du Mal&hellip; C'est l'Archange le plus respecté de tout le Ciel, et de loin.<br>
				la Source est celle de la Connaissance&hellip; Yves est le gardien des Connaissances de la Terre entière. Il régit l'apport de la connaissance tant philosophique que religieuse. Yves sait tout, et s'il ne le sait pas, il l'invente et sert donc de référence à tous, sauf à Dieu.</p>
		</details>

	</details>

	<details>
		<summary class="h3">Princes-démons</summary>

		<p>
			•&nbsp;<b>Abalam</b>, Prince de le Folie<br>
			•&nbsp;<b>Andrealphus</b>, Prince du Sexe<br>
		</p>

		<details class="liste">
			<summary>
				<div><b>Andromalius</b>, Prince du Jugement</div>
			</summary>
			<p>Andromalius est un Prince très puissant. Il est redouté ou haï des autres Démons car il est responsable auprès de Satan des renégats et des traîtres dans ses troupes. Une genre de «&nbsp;Police des Démons&nbsp;»&nbsp;! Ses serviteurs ont toujours des couvertures et ne se démasquent qu’au moment de la réalisation d'une «&nbsp;arrestation&nbsp;». Pour Andromalius, et pour ses serviteurs, un Démon est considéré comme renégat (et donc susceptible d'être tué) s'il agit contre son Prince, s'il possède une limitation l’empêchant d’agir conformément à l’intérêt de Satan et de son supérieur, où bien encore si ses actions démontrent une faiblesse grave dans sa façon de faire le Mal.<br>
				Satan utilise Andromalius pour contrôler les Démons qui causeraient des troubles dans ses rangs ou dans ceux de ses Princes. À noter qu'un Prince peut faire appel à des serviteurs d'Andromalius mais préfère souvent régler ses problèmes internes tout seul.
			</p>
		</details>

		<p>•&nbsp;<b>Asmodée</b>, Prince du Jeu</p>

		<details class="liste">
			<summary>
				<div><b>Baal</b>, Prince de la Guerre</div>
			</summary>
			<p>Baal est un guerrier. Beaucoup moins classe que Bélial et beaucoup plus réfléchi que Crocell, Baal n'est pas seulement une brute sans cervelle. Il a fait du combat une nécessité et même une façon de vivre. Les Démons de Baal sont envoyés sur terre pour détruire et massacrer ce qu'on laisse à leur portée, c'est donc à Baal de les contrôler de sa poigne de fer. Il dirige tous les régiments de combat importants des Enfers et est à la fois un grand stratège et un puissant combattant.</p>
		</details>

		<p>
			•&nbsp;<b>Baalberith</b>, Prince des Messagers<br>
			•&nbsp;<b>Beleth</b>, Prince des Cauchemars<br>
			•&nbsp;<b>Bélial</b>, Prince du Feu<br>
			•&nbsp;<b>Bifrons</b>, Prince des Morts<br>
			•&nbsp;<b>Caym</b>, Prince des Animaux<br>
			•&nbsp;<b>Crocell</b>, Prince du Froid<br>
			•&nbsp;<b>Furfur</b>, Prince du Hardcore<br>
			•&nbsp;<b>Gaziel</b>, Prince de la Terre<br>
			•&nbsp;<b>Haagenti</b>, Prince de la Gourmandise
		</p>
		<details class="liste">
			<summary>
				<div><b>Kobal</b>, Prince de l’Humour Noir</div>
			</summary>
			<p>
				Kobal est le frère d’Haagenti et ils forment tous les deux un duo de choc de l’humour infernal. Ils passent leur temps à jouer des mauvais tours aux Démons, aux familiers et aux autres Princes-Démons. Il ne descend sur Terre que pour aider ses serviteurs ou pour monter des canulars internationaux.<br>
				Kobal est le bouffon de Satan. Il est là pour le faire rire et il ne s’en sort pas trop mal.
			</p>
		</details>

		<p>•&nbsp;<b>Kronos</b>, Prince de l’Éternité </p>

		<details class="liste">
			<summary>
				<div><b>Malphas</b>, Prince de la Discorde</div>
			</summary>
			<p>
				Maplhas est bien considéré par Satan et n’est méprisé par aucun Prince-Démon. Le contraire n’est pas vrai, en effet, Malphas méprise tous ceux qui usent de la violence pour arriver à leurs fins et de nombreux Princes-Démons sont dans ce cas.<br>
				Satan utilise Maplhas pour toutes les missions diplomatiques de grande importance. Que ce soit pour déclencher une guerre, signer un traité commercial ou faire changer quelqu’un d’avis, Maplhas est toujours là.
			</p>
		</details>

		<p>•&nbsp;<b>Malthus</b>, Prince des Maladies</p>

		<details class="liste">
			<summary>
				<div><b>Mammon</b>, Prince de la Cupidité</div>
			</summary>
			<p>
				Mammon est le trésorier des Enfers. Il s’occupe de faire fructifier l’argent de Satan et ne s’entend bien qu’avec les Princes-Démons productifs (Nisroch en particlier). Tout le reste le laisse froid et ceux qui vnt jusqu’à détruire (Furfur, Crocell) lui sont particulièrement antipathiques. Il intervient très souvent sur Terre mais demande toujours à être payé pour ses services (même, et sourtout, par ses serviteurs).
			</p>
		</details>

		<p>
			•&nbsp;<b>Morax</b>, Prince des Dons artistiques<br>
			•&nbsp;<b>Nisroch</b>, Prince des Drogues<br>
			•&nbsp;<b>Nybbas</b>, Prince des Médias<br>
			•&nbsp;<b>Ouikka</b>, Prince des Airs<br>
			•&nbsp;<b>Samigina</b>, Prince des Vampires<br>
			•&nbsp;<b>Scox</b>, Prince des Âmes<br>
			•&nbsp;<b>Shaytan</b>, Prince de la Laideur<br>
			•&nbsp;<b>Uphir</b>, Prince de la Pollution<br>
			•&nbsp;<b>Valefor</b>, Prince des Voleurs<br>
			•&nbsp;<b>Vapula</b>, Prince de la Technologie<br>
			•&nbsp;<b>Véphar</b>, Prince des Océans
		</p>
	</details>

</article>

<article>
	<h2>Pouvoirs</h2>

	<details>
		<summary class="h3">Règles générales sur les pouvoirs</summary>

		<p>Un personnage débutant choisit 3 ou 4 pouvoirs au maximum.</p>

		<h4>Types de pouvoirs</h4>
		<p>Il existe deux catégories de pouvoirs.</p>
		<p><b>• Les pouvoirs de type <i>Avantage surnaturel</i>&nbsp;:</b> repérés par une astérisque, ils sont permanents, ne coûtent aucun PdM et ne nécessitent aucun jet de réussite.</p>
		<p><b>• Les pouvoirs de type <i>Sort</i>&nbsp;:</b> ils fonctionnent comme des sorts. Un jet de réussite est donc nécessaire pour les déclencher et ils impliquent une dépense de PdM.</p>

		<h4>Pouvoirs spéciaux</h4>
		<p>Les <i>Pouvoirs spéciaux</i> ne peuvent être acquis si et seulement si ils ont un lien <i>direct</i> avec la sphère d'intérêt du supérieur du personnage. C'est l'équivalent des pouvoirs spécifiques accordés aux serviteurs de tel ou tel Archange ou Prince-Démon dans la version originale du jeu.</p>

		<h4>Fonctionnement des pouvoirs de type <i>Sort</i></h4>
		<p>Ces pouvoirs fonctionnent comme décrit dans les RdB, à l'exception des points détaillés ci-dessous.</p>
		<p><b>• Temps nécessaire &amp; rituel&nbsp;:</b> sauf indication contraire, tous les pouvoirs se déclenchent de manière instantanée et sans rituel. Le personnage doit juste se concentrer. Cependant, un seul pouvoir peut être déclenché chaque round.</p>
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

	<details>
		<summary class="h3">
			<div>
				<?php if ($_SESSION["Statut"] == 3) { ?><a href="gestion-listes?req=pouvoir&id=0" class="nude ff-far">&#xf044;</a><?php } ?>
				Pouvoirs d’Anges
			</div>
		</summary>
		<?php
		foreach ($categories as $categorie) {
			$pouvoirs = $repo_powers->getPowersByCategories("ins", $categorie);
			$pouvoirs_anges = array_filter($pouvoirs, fn ($x) => $x->specific["Domaine"] !== "Démon");
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

	<details>
		<summary class="h3">
			<div>
				<?php if ($_SESSION["Statut"] == 3) { ?><a href="gestion-listes?req=pouvoir&id=0" class="nude ff-far">&#xf044;</a><?php } ?>
				Pouvoirs de Démons
			</div>
		</summary>
		<?php
		foreach ($categories as $categorie) {
			$pouvoirs = $repo_powers->getPowersByCategories("ins", $categorie);
			$pouvoirs_demons = array_filter($pouvoirs, fn ($x) => $x->specific["Domaine"] !== "Ange");
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

<article>
	<h2>Vie des anges &amp; démons</h2>

	<details>
		<summary class="h3">Incarnation</summary>
		<p>Les anges et démons s’incarnent dans un corps «&nbsp;créé&nbsp;» pour l’occasion. Il peut arriver, de manière exceptionnelle, qu’ils s’incarnent dans le corps d’un être humain qui vient de mourir, toujours dans un but bien précis.</p>
		<p>Un ange ou un démon nouvellement incarné n’a donc aucune identité officielle. Il s’incarne nu dans un endroit approprié (à la manière de <i>Terminator</i>). Le corps présente des traits lui permettant de passer pour un natif de la région où il s’est incarné.</p>
		<p>Ces corps ne vieillissent pas, ce qui peut obliger un ange ou un démon incarné depuis un certain temps à changer d’identité pour éviter d’éveiller les soupçons.</p>
	</details>

	<details>
		<summary class="h3">Souvenirs</summary>
		<p>Au moment de leur incarnation, anges et démons ne se souviennent de rien. Ni de leurs éventuelles précédentes incarnations (le <i>Grand Jeu</i> a commencé après la mort du Christ), ni de leur vie au Paradis ou en Enfer. Ces souvenirs peuvent revenir par bribe au cours du temps, dans des circonstances exceptionnelles (sur un 111 ou un 666 lors d’un jet de dés, ou après une expérience traumatisante ou un stress intense).</p>
	</details>

	<details>
		<summary class="h3">Grades</summary>
		<p>- Le <i>Grade 1</i> est obtenu dès que l’ange ou le démon réussit correctement une mission.</p>
		<p>- Le <i>Grade 2</i> est obtenu dès que l’ange ou le démon possède 2 pouvoirs de niveau IV et 10 PdM supplémentaires.</p>
		<p>- Le <i>Grade 3</i> est obtenu lors d’une action particulièrement éclatante ou d’une mission particulièrement réussie.</p>
	</details>

	<details>
		<summary class="h3">Mort</summary>
		<p>Lorsqu’un ange ou un démon meurt, son corps disparaît dans un petit «&nbsp;pops&nbsp;» sonore (sauf s’il s’est incarné dans un corps humain déjà existant). Ceci est également vrai pour toutes ses parties, y compris son sang, ainsi que tout ce qu’il portait. Le personnage retourne au Paradis ou en Enfer, jusqu'à une nouvelle incarnation.</p>
	</details>

</article>

<article>
	<h2>Pour le MJ</h2>

	<details>
		<summary class="h3">Missions &amp; points de personnage</summary>
		<p>À <i>In Nomine</i>, les points de personnage sont divisés en deux groupes&nbsp;:</p>
		<ul>
			<li>Les points classiques, servant à quantifier l’expérience acquise&nbsp;;</li>
			<li>Les points de «&nbsp;récompense&nbsp;» si la mission est réussie (10 à 15 pts pour une mission «&nbsp;classique&nbsp;»).</li>
		</ul>
		<p>Les points acquis grâce à l’expérience peuvent servir à tout, sauf à acquérir un nouveau pouvoir ou à augmenter le niveau de puissance d’un pouvoir (mais ils peuvent servir à améliorer le <i>score</i> d’un pouvoir).</p>
		<p>Les points de récompense ne peuvent servir qu’à l’acquisition d’un nouveau pouvoir ou à l’augmentation du niveau de puissance d’un pouvoir.</p>
	</details>

	<details>
		<summary class="h3">Organisation des forces du Bien</summary>
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
		<summary class="h3">Organisation des forces du Mal</summary>
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
		<summary class="h3">Monde des rêves</summary>
		<p>Une personne en train de rêver de manière naturelle est généralement seule dans son rêve. L’utilisation d’un pouvoir de rêve (<i>Rêve</i> ou <i>Cauchemar</i>) permet de pénétrer dans le rêve de la cible.</p>
		<p>Lorsqu’un personnage tente de rejoindre un rêve, le <i>Maître du rêve</i> peut tenter de s’y opposer. Faire un duel de compétence en pouvoir de rêve (ou <i>Volonté</i>, selon le plus avantageux).</p>

		<h4>Efficacité dans le monde des rêves</h4>
		La manière d’entrer dans le rêve influera sur la puissance et la liberté d’action du personnage. Ceci est simulé par l’Efficacité dans le Monde des Rêves (EMR).
		<table>
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
		<summary class="h3">Advanced Clochers &amp; Cathédrales</summary>
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