<article>
	<p>Ce chapitre présentent les règles permettant de gérer les poursuites entre véhicules, les pertes de contrôle et leurs conséquences, les combats entre véhicules et les conséquences de dommages causés à un véhicule.</p>
	<p>Il existe 5 familles de véhicules : <i>terrestres</i>, <i>aériens</i>, <i>flottants</i>, <i>sous-marins</i>, <i>spatiaux</i>. Les caractéristiques <i>Accélération</i> et <i>Manœuvrabilité</i> ne peuvent être comparées qu’entre véhicules de la même famille.</p>
</article>
	
<article><h2>Caractéristiques</h2>
	<details><summary class="h3">Accélération (Acc)</summary>
		<p>
			<b>Nulle (0) :</b> Accélération très faible, sans effet en termes de jeu. C’est le cas des gros véhicules (camion, bus, gros navires) ou de ceux disposant d’un moyen de propulsion peu efficace (vélo, voilier, dirigeable).<br/>
			<b>Faible (1) :</b> Camion vide, camionnette chargée, voiture poussive.<br/>
			<b>Médiocre (2) :</b> Petite voiture moderne, camionnette.<br/>
			<b>Moyenne (3) :</b> Voiture moyenne moderne, 50 cm<sup>3</sup>.<br/>
			<b>Bonne (4) :</b> Voiture assez puissante, moto légère.<br/>
			<b>Très bonne (5) :</b> Voiture de sport moderne, moto moyenne.<br/>
			<b>Excellente (6) :</b> Voiture exceptionnelle, moto sportive.
		</p>
		<p>Si le véhicule est chargé, son <i>Acc</i> est diminuée de 1, sans toutefois pouvoir être inférieure à 0.</p>
	</details>

	<details><summary class="h3">Vitesse maximale (Vm)</summary>
		<p>Dans l’espace, c’est l’<i>Acc</i> qui joue le rôle de cette caractéristique.</p>
	</details>

	<details><summary class="h3">Maniabilité (Ma)</summary>
		<p>Plus la <i>Maniabilité</i> d’un véhicule est grande, plus des écarts de mouvements brusques et des virages serrés sont possibles.</p>
		<p>
			<b>Nulle (0) :</b> Ne peut faire aucun écart. Lent et lourd à manœuvrer. Semi-remorque ou camion chargé. Tout véhicule d’une échelle de taille supérieure à 3 a automatiquement une maniabilité de zéro.<br/>
			<b>Mauvaise (1) :</b> Camionnette chargée. Voiture en mauvaise état, camion moyen vide.<br/>
			<b>Médiocre (2) :</b> Voiture moderne bas de gamme, camionnette vide. Très grosse moto.<br/>
			<b>Moyenne (3) :</b> Voiture moderne moyenne, petit van, petite moto urbaine.<br/>
			<b>Bonne (4) :</b> Voiture moderne de bonne qualité. Moto routière ou trail.<br/>
			<b>Très bonne (5) :</b> Voiture haut de gamme. Moto sportive.<br/>
			<b>Excellente (6) :</b> Voiture exceptionnelle.
		</p>
		<p>Si le véhicule est chargé, sa <i>Ma</i> est diminuée de 1, sans toutefois pouvoir être inférieure à 0.</p>
	</details>

	<details><summary class="h3">Résistance aux dégâts (RD)</summary>
		<p>La RD d’un véhicule fonctionne exactement comme celle d’une armure. Elle dépend grandement de la partie considérée. Par défaut, le score indiqué correspond à la carrosserie. Les tables de localisation doivent indiquer la RD de chaque partie du véhicule.</p>
	</details>

	<details><summary class="h3">Points de Structure (PdS)</summary>
		<p>Les points de Structure sont les PdV du véhicule. Pour un véhicule en métal de longueur <i>L</i> ayant les proportions d’une voiture : PdS = 13×<i>L</i><sup>0,96</sup>.</p>
		<p>Un véhicule ayant une forme plus compacte aura 10% de PdS en plus, un véhicule cubique ou sphérique en aura 20% en plus. À l’inverse, un véhicule fin ou très fin aura 10 à 20 % de PdS en moins.</p>
		<h4>Quelques ordres de grandeur indicatifs</h4>
		<p>48 à 52 PdS pour une voiture classique&nbsp;; 55 à 65 pour un pick-up, un SUV ou une voiture de luxe.<br/>
		100 PdS pour un bus, un camion ou un tracteur de semi-remorque,
		26 à 33 PdS pour une moto</p>
	</details>

	<details><summary class="h3">Intégrité</summary>
		<p>Cette caractéristique mesure la robustesse du véhicule, sa résistance aux mauvais traitements (choc, conditions extrêmes, attaque, etc.).</p>
	</details>

	<details><summary class="h3">Malfonction (Mlf)</summary>
		<p>Ce score mesure la fiabilité du véhicule. Le score par défaut est de 18 pour un véhicule fiable. Mais il peut baisser avec l’âge du véhicule, selon la qualité de son entretien, selon la technologie utilisée pour le fabriquer et selon son niveau d’endommagement. Le MJ fait un jet de Malfonction à chaque fois qu’il l’estime nécessaire.</p>
	</details>

</article>

<article><h2>Actions</h2>

	<details><summary class="h3">Jet de Contrôle</summary>
		<p>Un jet de <i>Contrôle</i> est un jet sous la compétence utilisée pour diriger le véhicule. Il est nécessaire chaque fois qu’il y a une prise de risque.</p>
		<p>Le MJ estime la difficulté de la manœuvre en tenant compte de la <i>Ma</i> du véhicule. Si le jet est raté, voir <i>Échec au jet de Contrôle</i>.</p>

		<h4>Jet de <i>Contrôle</i> de routine</h4>
		<p>Un jet de <i>Contrôle</i> de routine (à +5) peut également être demandé pour vérifier qu’un trajet au long cours se passe bien. En cas d’échec, une situation délicate survient. Un 2<sup>e</sup> jet de <i>Contrôle</i> doit être fait pour éviter l’accident.</p>
		
	</details>

	<details><summary class="h3">Poursuites</summary>
		<p>Ces règles de poursuite n’ont pas vocation à être très rigoureuses. Elles sont conçues pour permettre un maximum de fluidité en donnant un cadre aux estimations du MJ.</p>
		<p>Les poursuites se gèrent par des duels successifs de jet de Contrôle.</p>

		<h4>Portée</h4>
		<p>Au début de la poursuite, le MJ définit la portée séparant les deux véhicules. Pour la fluidité du jeu, on ne distinguera que 5 types de portée.</p>
		<p>
			<b>Courte 1 :</b> Les véhicules sont très proches sans être au contact.<br/>
			<b>Courte 2 :</b> Des échanges de tir sont possibles quasiment à tout moment entre les véhicules. La distance réelle peut varier selon le décor.<br/>
			<b>Moyenne 1 :</b> Les deux véhicules se voient par intermittence.<br/>
			<b>Moyenne 2 :</b> Un échange de tir est rarement possible.<br/>
			<b>Longue :</b> Les véhicules ne peuvent pas se tirer dessus, mais la poursuite est possible.
		</p>

		<h4>Annonce de la difficulté de la manœuvre</h4>
		<p>Le conducteur qui est poursuivi annonce la difficulté qu’il s’impose pour sa conduite et fait un jet de conduite avec tous les modificateurs approprié (voir ci-dessous). Le poursuivant a le droit de refuser ce malus, mais il perd alors automatiquement la séquence, sans prendre le risque de faire un accident.</p>
		<p><b>Maniabilité :</b> dans une situation ou le véhicule doit prendre des virages serrés, ajouter 2×&Delta;<i>Ma</i> (différence de <i>Maniabilité</i>) au jet de contrôle du conducteur ayant le véhicule le plus maniable.</p>
		<p><b>Vitesse :</b> en cas de trajectoire droite et sans obstacle, le véhicule le plus rapide gagne automatiquement le duel.</p>
		<p><b>Accélération :</b> dans les cas où le véhicule change fréquement d’allure (route de montagne, ville, etc) l’accélération du véhicule est un facteur prépondérant. Le conducteur du véhicule ayant l’<i>Acc</i> la plus élévée ajoute 2×&Delta;<i>Acc</i> (différence d’Accélération) à sa MR s’il réussit son jet de conduite.</p>
		
		<h4>Duel de contrôle</h4>
		<p>Si les deux jets sont un succès, la situation n’évolue pas, sauf si la MR d’un des protagonistes est supérieure de 3 à celle de l’autre. Si un seul des protagonistes gagne, il peut faire varier d’un rang la portée de la poursuite. Si un des conducteurs rate son jet de Contrôle, il perd le duel et doit immédiatement refaire un jet de Contrôle pour éviter l’accident, avec les mêmes modificateurs que le premier jet.</p>

		<div class="exemple">
			Une voiture de police (<i>Ma</i> 4, <i>Acc</i> 4) prend en chasse un chauffard conduisant une voiture de sport ancienne (<i>Ma</i> 4, <i>Acc</i> 5) sur une route de montagne.<br/>
			Le MJ décide que, le temps que les policiers démarrent la voiture et sortent de leur cachette, la poursuite commence à une portée « Moyenne 1 ».<br/>
			Le chauffard (<i>Conduite</i> 13) veut semer les policiers et décide de prendre quelques riques en s’imposant un malus de -2. Sur une route de montagne, la Manœuvrabilité et l’Accélération des véhicules sont importantes. La <i>Ma</i> des véhicules étant identique, elle n’avantage personne, mais l’<i>Acc</i> supérieure de la voiture de sport joue en faveur du poursuivi.<br/>
			Le chauffard obtient une MR de 3 et le policier qui conduit obtient une MR de 4. Le chauffard ajoute à sa MR 2 fois la différence d’<i>Acc</i> (2×1) pour une MR effective de 5. Il s’en tire un peu mieux que les policiers, mais pas de manière assez significative pour faire une différence en termes de portée.<br/>
			Après avoir décrit quelques virages serrés qui s’enchaînent et les pneus qui crissent, le MJ estime qu’il est temps de faire un nouveau duel. Le poursuivi décide d’augmenter l’allure et s’impose un malus de -3. Les policiers refusent de prendre un tel risque et perdent automatiquement le duel. Le chauffard doit néanmoins faire son jet de <i>Conduite</i> à -3. Il le rate de 1. Sa voiture dérape dans un virage, ce qui lui fait perdre également le duel (la portée n’évolue donc toujours pas pour cette séquence). Il doit donc immédiatement faire un second jet à -3 pour éviter l’accident.
		</div>


	</details>

	<details><summary class="h3">Échec au jet de Contrôle</summary>
		<p>En cas d’échec, les conséquences varient selon la ME du jet de contrôle, du type de véhicule et de la nature du terrain dans lequel ce véhicule se déplace. Pour une voiture, cela peut aller d’un simple dérapage à une sortie de route suivie de tonneaux. Le tableau suivant permet d’estimer les conséquences d’un jet de <i>Contrôle</i> raté.</p>

		<table class="alternate-e left-2">
			<tr><th>ME</th> <th>Interprétation</th></tr>
			<tr><td>1</td>	<td>Erreur minime. Un 2<sup>e</sup> jet de contrôle, avec les mêmes malus, pour éviter l’accident. Les conséquences sont minimales</td></tr>
			<tr><td>2</td>	<td>Erreur minime. Les conséquences sont minimales.</td></tr>
			<tr><td>3-4</td><td>Erreur moyenne. Les conséquences sont celles «&nbsp;raisonnablement attendues&nbsp;» pour un accident dans ces conditions.</td></tr>
			<tr><td>5-6</td><td>Erreur grave. Les occupants du véhicule sont assez malchanceux, les conséquences sont graves.</td></tr>
			<tr><td>7+</td>	<td>Erreur catastrophique. Le pire se produit.</td></tr>
		</table>

		<div class="exemple">
			Reprenons l’exemple précédent. Le chauffard vient de rater son second jet de <i>Contrôle</i> de 2. Le véhicule dérape et vient glisser contre la falaise de pierre. Il est amoché mais peut encore fonctionner (cf. plus bas pour la gestion des dégâts).<br/>
			S’il avait raté son jet de 3 ou 4, le véhicule aurait fini par heurter un talus ou un rocher, après avoir été ralenti par son contact avec la falaise. Il aurait été hors d’état de marche et son occupant aurait pu subir quelques dégâts (surtout sans ceinture).<br/>
			Une erreur grave aurait pu entraîner un tonneau et une fin dans le fossé, alors qu’une erreur catastrophique l’aurait envoyé au fond du ravin.
		</div>

	</details>

	<details><summary class="h3">Collision</summary>
		<p>Une collision est un choc entre un véhicule et un obstacle (autre véhicule, bâtiment, être-vivant). La gravité de la collision est estimée par le MJ pour déterminer les dégâts reçus par le véhicule. Les calculs sont gérés par le widget de la <a href="table-jeu"><i>Table de jeu</i></a>.</p>
		
		<h4>Conséquences pour les passagers</h4>
		<p>Une ceinture annule 2d de dégâts et un airbag 4d de dégâts au minimum (jusqu’à 6d pour un système haut de gamme). Ces protections ne sont pas cumulables.</p>
		<p>Les dégâts reçus par les passagers sont déterminés en utilisant les règles du paragraphe <i>Dégâts aux occupants</i>.</p>

		<h4>Conséquences pour une créature percutée</h4>
		<p>Déterminer la gravité de la collision (qui peut être différente de celle pour le véhicule).</p>
		<p>Les dégâts (pour un être humain) se calculent en fonction de la gravité : Légère = 1d ; Moyenne = 3d ; Grave = 6d ; Très grave = 6d×2. La RD s’applique normalement. Ces dégâts sont augmentés en proportion des « PdV moyens » de la créature.</p>
		
		<h4>Éperonnage</h4>
		<p>On peut placer à l’avant d’un véhicule de quoi éperonner un autre appareil en limitant les dégâts subis par l’attaquant.</p>
		<p>Le véhicule qui éperonne subit des dégâts dont la gravité est d’un niveau inférieur à ce qu’il subirait sans son éperon (qui peut par ailleurs lui procurer une RD importante à l’endroit de l’impact).</p>
	</details>

	<details><summary class="h3">Attaque</summary>
		<p>Une attaque d’un véhicule est traitée comme une attaque à distance.</p>
	</details>

	<details><summary class="h3">Défense</summary>
		<h4>Se rendre plus difficile à toucher</h4>
		<p>Si un pilote tente des manœuvres acrobatiques pour se rendre difficile à toucher. Il revient au MJ d’établir un lien entre la MR du jet de Contrôle du pilote et le malus infligé à l’attaquant.</p>
		
		<h4>Esquiver un missile direct</h4>
		<p>Une esquive n’est possible que si on a le temps d’anticiper la trajectoire du missile, c’est-à-dire quand celui-ci est tiré d’assez loin.</p>
		
		<h4>Défense contre missile guidé</h4>
		<p>Trois stratégies anti-missiles existent :</p>
		<ul>
			<li>Détruire le missile en lui tirant dessus. Le missile encaisse les dégâts comme un véhicule (avec une <i>Intégrité</i> généralement élevée). Si le missile est gravement endommagé, il ne pourra pas atteindre son but.</li>
			<li>Lancer un leurre. Le missile doit refaire un jet d’<i>Acquisition</i>. En cas d’échec, le missile suit le leurre.</li>
			<li>Esquiver le missile au tout dernier moment. Une manœuvre <i>Assez difficile</i> imposera un -1 au jet d’attaque du missile, une manœuvre <i>Difficile</i> imposera un -3 et une manœuvre <i>Très difficile</i> un -5. Ceci suppose un véhicule dont la Ma est de 4. Modifier les malus en cas de Ma différente.</li>
		</ul>
	</details>

</article>

<article><h2>Effets des dégâts</h2>

	<p>Les effets des dégâts sur un véhicule suivent les règles décrites au chapitre <i>Combat</i>.</p>

	<details><summary class="h3">Perte de contrôle du véhicule</summary>
		<p>Lorsqu’un véhicule subit des dégâts, il faut faire un jet de <i>Contrôle</i> dont la difficulté dépend des dégâts reçus par le véhicule.</p>
		<table class="alternate-e left-1">
			<tr><th>Dégâts reçus</th>	<th>Difficulté</th></tr>
			<tr><td>Légers</td>			<td>0</td></tr>
			<tr><td>Moyens</td>			<td>-5</td></tr>
			<tr><td>Graves</td>			<td>-10</td></tr>
			<tr><td>Très graves</td>	<td>Impossible</td></tr>
		</table>

	</details>

	<details><summary class="h3">Dégâts aux occupants</summary>

		<h4>Dégâts «&nbsp;très localisés&nbsp;»</h4>
		<p>Un occupant n’est blessé que si cet événement est tiré sur la table de localisation. Les dégâts sont calculés sur la base des dégâts bruts en tenant compte de la RD traversée (vitre ou carrosserie, etc.)</p>

		<h4>Dégâts «&nbsp;normaux&nbsp;»</h4>
		<p>Selon le contexte (taille du véhicule, localisation des occupants, etc.), les occupants sont automatiquement affectés <i>ou bien</i> ils ne sont affectés que si cela est indiqué dans les effets secondaires.</p>
		<p>Les blessures peuvent être multiples&nbsp;: pour chaque dé de dégâts, déterminer une localisation (on peut se limiter à 4 localisations pour accélérer le calcul). Les dégâts sont en général des dégâts de broyage, mais du tranchant voire du perforant n’est pas exclu (jet de probabilité – <i>Peu probable</i> à <i>Très peu probable</i> selon les circonstances).</p>

		<table class="alternate-e left-1">
			<tr><th>Dégâts au véhicule ou localisation</th>	<th>Dégâts occupants</th></tr>
			<tr><td>Très légers</td>						<td>aucun</td></tr>
			<tr><td>Légers ou niv. 1</td>					<td>jusqu’à 1d-3</td></tr>
			<tr><td>Moyens ou niv. 2</td>					<td>jusqu’à 2d</td></tr>
			<tr><td>Grave ou niv. 3</td>					<td>jusqu’à 6d</td></tr>
			<tr><td>Très grave ou niv. 4</td>				<td>jusqu’à 6d×2</td></tr>
			<tr><td>Extrême ou niv. 5</td>					<td>jusqu’à 6d×4</td></tr>
		</table>
		<p>Selon le contexte également, les dégâts occasionnés aux occupants peuvent être découplés de ± 1 niveau par rapport aux dégâts subis par le véhicule.</p>

	</details>

	<details><summary class="h3">État général</summary>
		<p>Si un véhicule est endommagé, cela affecte ses performances. Les modificateurs de <i>Ma</i>, <i>Acc</i> et <i>Vm</i> donnés ci-dessous sont indépendants et cumulables avec tout autre effet secondaire.</p>
		<table class="alternate-o left-2">
			<tr>
				<th>L</th>
				<td>Le véhicule fonctionne normalement, sauf en cas d’effets secondaires. -1 aux jet d’Intégrité.</td>
			</tr>
			<tr>
				<th>M</th>
				<td>Le véhicule commence à être bien abîmé mais il est encore fonctionnel globalement, au moins pendant un certain temps. Il peut présenter quelques petites ouvertures dans la coque, mais qui peuvent être réparées sans difficultés majeures. <i>Ma</i> -1 ;<i> Acc</i> -1 ; <i>Vm</i> ×0,67. -2 aux jet d’<i>Intégrité</i>.</td>
			</tr>
			<tr>
				<th>G</th>
				<td>Le véhicule n’en peut plus, il est très peu manœuvrable et se traîne plus qu’il n’avance. La coque présente une ou plusieurs brèches ne pouvant être réparées de manière improvisée. Si le véhicule n’est pas compartimenté et qu’il s’agit d’un véhicule aquatique ou spatiale, sa survie est compromise à assez court terme. <i>Ma</i> -2 ; <i>Acc</i> -2 ; <i>Vm</i> ×0,33. -3 aux jet d’<i>Intégrité</i>.</td>
			</tr>
			<tr>
				<th>HS</th>
				<td>Le véhicule est inutilisable mais, avec le matériel et les compétences nécessaires, il est techniquement réparable. -4 aux jet d’<i>Intégrité</i>.</td>
			</tr>
			<tr>
				<th>D</th>
				<td>Le véhicule est endommagé au point d’être irréparable. Ce n’est plus qu’une carcasse éventrée et broyée.</td>
			</tr>
		</table>
		
		<p>Remarque : la <i>Ma</i> et l’<i>Acc</i> d’un véhicule ne peuvent jamais être négatives.</p>
	</details>

	<details><summary class="h3">Types d’effets secondaires</summary>
		<p>Les effets secondaires des dégâts sur un véhicule sont de 6 catégories différentes. Chaque type de véhicule devrait avoir sa propre table d’effets secondaires.</p>
		<table class="alternate-o left-2">
			<tr><th>1</th>	<td>Convertisseur d’énergie : Moteur, réacteur.</td></tr>
			<tr><th>2</th>	<td>Occupants : Pilote(s) ou passagers, pont de commande, quartiers de l’équipage, etc.</td></tr>
			<tr><th>3</th> <td>Systèmes de propusion et manœuvre : Roue, chenille, hélice, aileron, gouvernail, freins, etc.</td></tr>
			<tr><th>4</th>	<td>Systèmes structurels : Porte, sas, tourelle, bras manipulateur, etc.</td></tr>
			<tr><th>5</th>	<td>Équipement divers : arme, senseurs, système de survie, ordinateur de bord, et tout système qui n’est pas essentiel à la bonne marche immédiate du véhicule.</td></tr>
			<tr><th>6</th>	<td>Source d’énergie : Réservoir de carburant, générateur, chaudière, batteries, etc.</td></tr>
		</table>
	</details>
</article>

<article><h2>Règles spécifiques</h2>
	<details><summary class="h3">Voiture à moteur thermique</summary>
		<p>Une voiture non-blindée a une RD 5 pour la carrosserie (+1 à +2 pour une voiture ancienne ou de luxe) et 3 pour les vitres.</p>

		<table class="alternate-e left-1">
			<tr><th>Localisation &amp; Effets secondaires</th></tr>
			<tr>
				<td>
					<b class="color1">Moteur</b><br/>
					<b>Niv. 1 :</b> fonctionne normalement 2d minutes puis panne<br/>
					<b>Niv. 2 :</b> fonctionne 1d minutes (-2 Acc, -50% Vit.) puis HS
				</td>
			</tr>
			<tr>
				<td>
					<b class="color1">Roue</b><br/>
					Le pneu est crevé (niv.1) ou éclate (niv. 2+). <i>Ma</i> -2 pour une seule roue crevée sur une voiture. Le véhicule est incontrôlable avec 2 pneus crevés.
				</td>
			</tr>
			<tr>
				<td>
					<b class="color1">Réservoir</b><br/>
					<b>Niv. 1 :</b> réservoir percé. La fuite ne posera pas de problème immédiat sauf en cas de flammes.<br/>
					<b>Niv. 2 :</b> Le carburant peut prendre feu – <b>1-5</b> pour de l’essence et <b>1-3</b> pour du gasoil.
				</td>
			</tr>
		</table>
	</details>

	<details><summary class="h3">Moto à moteur thermique</summary>
		<p>Une moto à une RD générale de 3.</p>
		<p>Pour les effets secondaires, voir <i>voiture à moteur thermique</i>.</p>
		<p>Une chute sans collision est considérée comme une collision <i>légère</i> ou <i>moyenne</i> selon les circonstances. <br/>
		Le pilote reçoit des dégâts qui dépendent de la gravité de la chute&nbsp;: soit d’un niveau inférieur, soit du même niveau (probabilité 50–50) </p>

	</details>
</article>