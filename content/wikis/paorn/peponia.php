<h2>Péponia</h2>


<div class="wiki-right-element flow">
	<figure>
		<img src="/assets/img_paorn/peponia-01.webp?v=2">
		<figcaption>Carte générale</figcaption>
	</figure>
	<figure>
		<img src="/assets/img_paorn/peponia-02.webp">
		<figcaption>Péponia et ses alentours</figcaption>
	</figure>
</div>

<!-- Description, Habitants, Politique, Activités -->
<p>Péponia est un village laurien typique. Situé sur les terres de la famille Karras, à mi-chemin entre Loelio et Parna, le village compte environ 600 habitants.</p>
<p>On y élève principalement des chèvres, on y cultive des oliviers, de la vigne, de figuiers, du blé et de l’orge.</p>
<p>Péponia possède un moulin, un temple pentathéiste, un forgeron, une auberge (l’<i>auberge du Château</i>) avec écuries, trois tavernes, un armurier, un apothicaire.</p>
<p>On trouve, dans les alentours, quelques fermes et hameaux (dans un rayon de quelques kilomètres).</p>
<p>Le château Karras se trouve à 1 km, en haut d’une colline entourée de vignes et d’oliviers.</p>

<!-- PNJ & groupes influents -->
<h4>Arzu Karras</h4>
<p>Propriétaire du domaine, c’est également le <i>Grand Connétable</i>, c’est-à-dire le responsable des <i>Protecteurs</i> à l’échelle du Royaume. Sa fonction ne lui permet que rarement d’être dans son château. Il n’y passe que quelques jours par an. Le reste du temps, il est à Parna, où il exerce ses fonctions.</p>
<?php if ($admin || $_SESSION["id"] === 6): ?>
	<p class="admin">
		Il a toujours gardé contact avec son fils bâtard, Jurgen, et s’inquiète de son avenir. Il l’a envoyé chez son frère afin de l’éloigner de ses fréquentations en espérant qu’il se reprenne en mains.
	</p>
<?php endif ?>

<h4>PNJ divers</h4>
<?php if ($admin || $_SESSION["id"] === 6): ?>
	<div class="admin flow">
		<h5>PNJ mineurs liés à Jurgen</h5>
		<!-- <p><b>• Famille de Jurgen&nbsp;:</b> Aenor, 37 ans, sa mère. Padrig, 40 ans, son beau-père. Moïra, 16 ans, sa demi-sœur. Aodren 14 ans, son demi-frère.</p> -->

		<p><b>• Aenor (37 ans), sa mère</b>. C’est une très belle femme, ce qui a fait succomber Arzu, son seigneur, lors de ses visites dans la ferme familiale où elle élève des volailles et des porcs. Jurgen lui ressemble énormément. Ils sont très liés.</p>

		<p><b>• Moïra (16 ans), sa demi-sœur</b>. Elle est passionnée d’herboristerie et soigne dès qu’elle en a l’occasion sa famille et les villageois. Elle est gaie, rêveuse, solitaire. Elle aime les longues promenades au cours desquelles elle cherche des plantes et des baies. Elle aime aussi les oiseaux qu’elle s’amuse à imiter. Elle est très douée pour le calcul et s’intéresse à la science. Elle aime aider sa mère à tenir les comptes. Elle aussi ressemble beaucoup à sa mère et les garçons du village aiment attirer son attention.</p>

		<p><b>• Aodren (14 ans), son demi-frère</b>. Espiègle, fouineur et passionné par l’armée. Il aime se rendre au château pour épier les entraînements des soldats. Dès qu’il en a l’occasion, il se rend au village, pour s’extraire de ses obligations à la ferme et passe son temps chez Ivo, l’armurier. Son rêve est de devenir soldat.</p>

		<p><b>• Padrig, 40 ans</b>, son beau-père. Il est charcutier au village où il a une échoppe. Il est sévère et honnête. Il est apprécié au village où il est né.</p>

		<p><b>• Aidan, 19 ans, fils de l’apothicaire</b>. Il connaît Jurgen depuis toujours. Ils ont fait les 400 coups ensemble. Rebelle et bagarreur, il aime faire la fête et jouer. Il passe ses soirées à la taverne. Son père tente de le former pour prendre sa succession, sans grand succès.</p>

		<p><b>• Kieran, 18 ans, ami d’enfance</b>. C’est le fils du parcheminier. Il est amoureux de Moïra. Elle aime sa compagnie car ils partagent la même passion pour les plantes. Elle le considère comme son meilleur ami. C’est l’ami d’enfance de Jurgen et lui a confié ses sentiments envers sa sœur. Jurgen l’aide à conquérir sa sœur. C’est un jeune homme calme, réfléchi et qui est avide de connaissances. Il est celui qui parvient à raisonner Jurgen. Il protège Jurgen qu’il considère comme un frère.</p>

		<p><b>• Edama, 18 ans, fille du tailleur</b>. Amoureux l’un de l’autre depuis l’enfance mais elle est promise au fils du tailleur du château.</p>

		<p><b>• La bande&nbsp;: Aze, Estur, Ezmond.</b> La bande que fréquentait Jurgen lorsqu’il vivait à Parna. Leurs parents, tous exerçant des métiers « infâmes », histrion, bourreau, fossoyeur ou encore équarisseurs en font des enfants rebelles et décidés à se venger de l’injustice que la profession de leurs parents fait peser sur eux. Ils vivent de larcins et fréquentent les tavernes où ils jouent jusqu’au bout de la nuit. Ils sont bien connus dans le village mais personne n’ose s’opposer à eux de peur des représailles. Ils font la connaissance d’Aidan qui, pour s’intégrer au groupe, n’hésite pas à les aider dans leurs forfaits. C’est lui qui les présente à Jurgen qui les rejoint et participe à quelques cambriolages pour financer son addiction au jeu.</p>

	</div>
<?php endif ?>

<p><b>• Ariathos,</b> le bailli, homme de confiance d’Arzu Karras. Il dirige le village en son absence. Il loge au château.</p>

<p><b>• Ivo,</b> armurier. <?php if ($admin || $_SESSION["id"] === 6) { ?> <span class="admin">Un ami de la famille de Jurgen. Il aime expliquer à Aodren la fabrication des armes et ne rapporte pas à ses parents sa présence.</span><?php } ?></p>

<p><b>• Iona,</b> 50 ans, gouvernante du château de Karras, également sage-femme du village. <?php if ($admin || $_SESSION["id"] === 6) { ?> <span class="admin">A aidé la mère de Jurgen à accoucher. Elle a un lien fort avec lui et le considère comme le fils, issu de ses amours avec un noble de Parna et qu’elle a perdu en couches. Elle continue de rendre visite à sa famille et se soucie de l’éducation de Jurgen. Elle aime le gâter.</span><?php } ?></p>

<p><b>• Ewen</b>, 40 ans, patron de taverne. <?php if ($admin || $_SESSION["id"] === 6) { ?> <span class="admin">Il apprécie Jurgen pour la bonne humeur qu’il apporte avec lui lors de ses visites. Il connaît tous les potins du village.</span><?php } ?></p>

<p><b>• Pyrrha</b>, 45 ans, prêtresse du temple pentathéiste, longs cheveux noirs cascadant en boucles abondantes, encadrant un visage rond et bienveillant. Yeux sombres brillant d'une lueur chaleureuse, reflétant sa nature compatissante. Malgré sa petite taille et ses formes rondes, elle se déplace avec une grâce naturelle. Sa mémoire infaillible des rites et des légendes et sa dévotion envers le Pentatos et sa communauté lui valent le respect et l'affection de tous.</p>

<p><b>• Maître Athenios</b>, 40 ans, gestionnaire du château Karras. Cheveux longs ondulés noirs, barbe broussailleuse.</p>

<!-- Lieux intéressants -->
<h4>Lieux intéressants</h4>
<p><b>Route vers Parna&nbsp;:</b> 32 km</p>
<p><b>Route vers Loelio&nbsp;:</b> 33 km</p>

<!-- Particularités -->
<h4>La Fête des Moissons</h4>
<p>La Fête des Moissons de Péponia est une célébration annuelle marquant la fin des récoltes estivales et le début des vendanges. Elle se déroule à la fin du mois d'août, lorsque les champs ont été moissonnés et que les vignes sont prêtes à être vendangées. C'est un moment de réjouissance pour les villageois qui se rassemblent pour honorer la terre et ses fruits.</p>
<p>La fête commence par un rituel au temple pentatheutiste, où les villageois remercient les dieux pour la récolte abondante. Ils apportent des offrandes de fruits, de pain et de vin au temple.</p>
<p>Le temple est décoré avec des gerbes de blé et des grappes de raisin, symbolisant la prospérité et l'abondance</p>
<p>La fête se poursuit par un banquet, des danses et différents concours d’adresse et de force.</p>

<?php if ($admin): ?>
	<div class="admin flow">
		<h4>Histoire, mythes &amp; légendes</h4>

		<h5>La Récolte Miraculeuse</h5>
		<p>Il y a une cinquantaine d'années, Péponia a connu une période de sécheresse terrible. Les récoltes étaient maigres, les puits étaient à sec et le bétail maigrissait à vue d’œil. Voyant la famine approcher, Alector, le prêtre du temple pentathéiste de l’époque, appela le village à se rassembler. Il pria les dieux avec ferveur pendant sept jours et sept nuits, refusant de manger ou de boire jusqu’à ce qu’ils répondent à ses prières. Le septième jour, alors que le soleil se couchait, un orage d’une violence inouïe éclata. La pluie tomba sans discontinuer pendant trois jours et trois nuits, et lorsque le ciel se dégagea enfin, un arc-en-ciel magnifique apparut au-dessus du village. Les champs étaient gorgés d’eau, et en quelques semaines, la végétation avait repris vie. La récolte qui suivit fut la plus abondante que Péponia ait jamais connue, sauvant les villageois de la famine. On raconte encore aujourd’hui que cette récolte miraculeuse fut un cadeau des dieux, accordés au village grâce à la foi et à la dévotion du vieux prêtre.</p>

		<h5>Le fantôme du lac de Kaphaïstos</h5>
		<p>Non loin de Péponia se trouve un petit lac de montagne, aux eaux sombres et profondes.  La légende raconte qu'une jeune femme, promise à un homme cruel et violent, s’y serait noyée il y a fort longtemps pour échapper à son destin funeste. Depuis, son esprit hanterait les lieux. On raconte qu'elle apparaît les nuits de pleine lune,  glissant à la surface de l'eau sous la forme d’une silhouette spectrale vêtue d'une longue robe blanche. Certains disent l’avoir entendue chanter d'une voix douce et mélancolique,  tandis que d’autres affirment qu’elle tente d’attirer les voyageurs imprudents vers le fond du lac.  Beaucoup de villageois refusent de s'approcher du lac une fois la nuit tombée,  de peur de croiser le chemin de la Dame Blanche et de subir son funeste courroux.</p>

	</div>
<?php endif ?>