// Widget "Attaque simple" – complète le code dés dégâts à partir de la force et de la carac de l’arme
function calcul_code_des() {
	let val_for = get_id("as-force").value
	let code_arme = get_id("as-code-arme").value
	let mains = get_id("as-mains").value

	if (parseInt(val_for) && code_arme) {
		code_arme = "B." + code_arme;
		let data = new FormData;
		data.append("for", val_for);
		data.append("notes", code_arme);
		data.append("mains", mains);
		fetch("/api/weapon-damages", {
			method: 'post',
			body: data
		})
			.then(response => response.json())
			.then(response => response.data.damages)
			.then(damage => damage.slice(2))
			.then(damage => get_id("as-code-degats").value = damage)
	}
}

// Widget "Attaque simple" – détermine une localisation et les dégâts
function calcul_deg_arme() {
	let deg_arme = get_id("as-code-degats").value
	let display = get_id("msg-content")

	let deg = Math.max(roll(deg_arme), 0)
	get_id("bl_deg_b").value = deg

	let jet_localisation = roll("3d")
	let localisation_i = localisations[jet_localisation][0]
	let select_loc = get_id("bl_localisation").querySelectorAll("option")
	for (localisation_j of select_loc) { if (localisation_j.value == localisations[jet_localisation][1]) { localisation_j.selected = true } }

	if (deg_arme != "") {
		display.value += (display.value.length != 0 ? " " : "") + localisation_i + " " + deg_arme + " → " + deg
		send_msg("jet")
	}
}

// Widget rafales
function calcul_rafale() {

	let display = get_id("msg-content")
	let Rcl = get_id('rf_rcl').value
	let b = get_id('rf_nbre_balles').value
	let MR = get_id('rf_MR').value
	let des_degats = get_id('rf_degats').value
	let alpha = 1.5 / (2 - Rcl);
	let nbre = Math.round(Math.max(Math.min((0.133 * MR + 0.333) * ((1.54 - alpha) * (Math.E) ** (-0.1 * (b - 1) / alpha) + alpha), 1), 0) * b);
	let resultat = "Rcl " + Rcl + "&nbsp;; Balles " + b + "&nbsp;; MR " + MR + "&nbsp;; Dégâts " + des_degats + "<br/>"

	for (let i = 0; i < nbre; i++) {
		let degats_resultat = roll(des_degats);
		resultat += "&emsp;<b>" + (i + 1) + ".</b> " + degats_resultat + " pts – " + localisations[roll("3d")][0] + "<br/>";
	}

	if (Rcl && b && MR && des_degats) {
		display.value += (display.value.length != 0 ? " " : "") + resultat
		send_msg("jet")
	}

}

// Widget explosions – calcul % blast et fragmentation reçu
function calc_frac_explosion() {
	let surface_blast = parseFloat(get_value("exp_surface_blast"))
	let surface_frag = parseFloat(get_value("exp_surface_frag"))
	let distance = parseFloat(get_value("exp_distance"))
	if (surface_blast && distance) { get_id("exp_%_blast").value = (surface_blast / (6.3 * distance ** 2) * 100).toFixed(5) }
	if (surface_frag && distance) { get_id("exp_%_frag").value = (surface_frag / (6.3 * distance ** 2) * 100).toFixed(5) }
}

// Widget explosion – calcul dégâts explosion
function calcul_deg_explosion() {
	let frac_blast = get_id("exp_%_blast").value
	let frac_frag = get_id("exp_%_frag").value
	let deg_ref = get_value("exp_degats")
	let parse_deg = roll(deg_ref, true)
	let isFrag = get_id("exp_frag").checked

	let deg = parse_deg[1] * 5
	switch (parse_deg[3]) {
		case "+": deg += parse_deg[4]; break;
		case "-": deg -= parse_deg[4]; break;
		case "*": deg *= parse_deg[4]; break;
		case "/": deg /= parse_deg[4]; break;
	}
	deg = deg * (0.7 + 0.6 * Math.random()) // nbre dés ×5 randomisé à 30%
	deg = 10 * deg * frac_blast / 100		// dégâts maxi et surface exposée
	deg = (4.5 * deg ** 0.5).toFixed(0) // compression de la valeur des dégâts autour de 20

	let nbr_eclats = parse_deg[1] * 30 * frac_frag / 100
	switch (parse_deg[3]) {
		case "*": nbr_eclats *= parse_deg[4]; break;
		case "/": nbr_eclats /= parse_deg[4]; break;
	}

	nbr_eclats = nbr_eclats ** 0.67 // compression du nombre d’éclats
	if (!isFrag) { nbr_eclats /= 2 } // si pas explosif à fragmentation

	let nbr_eclats_random = 0

	if (nbr_eclats >= 1) {
		nbr_eclats = Math.round(nbr_eclats)
		for (let i = 0; i < nbr_eclats; i++) { nbr_eclats_random += roll("1d3-1") }
	}
	else {
		if (Math.random() <= nbr_eclats) { nbr_eclats_random += 1 }
		if (Math.random() <= nbr_eclats / 2) { nbr_eclats_random += 1 }
	}
	nbr_eclats = nbr_eclats_random

	if (frac_blast && deg_ref) {
		let display = get_id("msg-content")
		display.value += "Explosion " + deg_ref + " – Blast " + frac_blast + "&nbsp;% – Éclats " + frac_frag + "&nbsp;%<br/>" +
			"Dégâts blast&nbsp;: " + deg + "&nbsp;pts&nbsp;; nbre éclats&nbsp;: " + nbr_eclats
		send_msg("jet")
	}
}

/* Widget critique */
function roll_critique() {
	let type = get_id("critiques").value
	let resultat
	let table_resultats

	switch (type) {
		case "rc_attaque":
			table_resultats = {
				2: "Dégâts ×2 ; l’ennemi est sonné s’il reçoit des dégâts.",
				5: "Dégâts ×2, RD divisée par 2 ; l’ennemi est sonné (niveau 2) s’il reçoit des dégâts.",
				6: "Dégâts ×3, RD divisée par 3 ; l’ennemi perd conscience s’il reçoit des dégâts."
			}
			resultat = read_table(table_resultats, roll("1d"))
			break

		case "ec_arme_contact":
			table_resultats = {
				1: "Arme désapprêtée.",
				2: "Jet de <i>Dex</i>-3 pour ne pas tomber. Au tour suivant perte initiative et <i>Défenses</i> à -2.",
				3: "L’attaquant perd son arme, elle atterrit à 1d mètre de lui ou l’arme se plante dans le décor (choix du MJ)",
				4: "L’arme peut se briser&nbsp;: probabilité de n/6 que l’arme se brise. n = 2 en cas d’attaque ou en parant une arme de même poids, n = 3 pour une arme 2× plus lourde, n = 4 pour une arme 3× plus lourde, etc.",
				5: "L’attaquant blesse un allié. Si ce n’est pas possible, il perd son arme.",
				6: "L’attaquant se blesse avec son arme (demi-dégâts normaux) ou se foule l’épaule / se blesse la main (bras/main handicapé, une journée pour se rétablir)."
			}
			resultat = read_table(table_resultats, roll("1d"))
			break

		case "ec_arme_projectiles":
			let complement_mlf = "Si jet &ge; <i>Mlf</i>, l’arme à 50&nbsp;% de chance de dysfonctionner (voir chapitre <i>Armes &amp; armures</i>). Sinon "
			table_resultats = {
				2: "l’arme glisse des mains du personnage. Le tir est manqué et le personnage doit réapprêter son arme.",
				4: "le personnage hésite. Il perd le tour.",
				6: "une victime au hasard, dans la direction de la cible, est touchée.",
			}
			resultat = complement_mlf + read_table(table_resultats, roll("1d"))
			break

		case "ec_arme_jet":
			table_resultats = {
				1: "L’attaquant se foule l’épaule ou se bloque le dos (bras handicapé, une journée pour se rétablir).",
				2: "Jet de <i>Dex</i>-3 pour ne pas tomber.",
				3: "L’arme a 50&nbsp;% de chance de se briser.",
				4: "Le personnage hésite. Il perd son tour.",
				6: "Une victime au hasard, dans la direction de la cible, est touchée.",
			}
			resultat = read_table(table_resultats, roll("1d"))
			break

		case "ec_mouvement":
			table_resultats = {
				1: "Jet de <i>Dex</i>-3 pour ne pas tomber.",
				2: "Le personnage tombe.",
				3: "Le personnage tombe et est sonné.",
				4: "Le personnage tombe, subit 1d-3 de dégâts au bras ou à la main et est sonné.",
				5: "Le personnage tombe la tête la première, 1d-3 de dégâts à la tête. Le personnage est automatiquement sonné, voire assommé si les dégâts sont suffisants.",
				6: "Le personnage fait une chute spectaculaire. Il encaisse 2×1d-3 de dégâts et est gravement sonné.",
			}
			resultat = read_table(table_resultats, roll("1d"))
			break

		case "ec_sort":
			table_resultats = {
				7: "Le sort semble agir, mais les effets produits ne sont qu'un pâle ersatz des effets attendus.",
				8: "Le sort échoue. L'initiateur est sonné au niveau 2.",
				9: "Les effets du sort se limitent à un grand bruit suivi de crépitement de lumière colorée.",
				10: "Les effets sont l’inverse de ceux attendus. Refaire un jet si ce n’est pas possible.",
				11: "Le sort affecte une autre cible au choix du MJ. Refaire un jet si ce n’est pas possible.",
				12: "Le sort se retourne contre son initiateur. Refaire un jet si ce n’est pas possible.",
				13: "Le sort échoue. L’initiateur subit [1d×niveau de puissance] de dégâts, perd tous ses PdM et ceux de la ou des pierres de puissance qu’il portait.",
				14: "Le sort échoue. L’initiateur tombe dans le coma pendant 1d minutes / heures / jours / semaines / mois selon le niveau du sort.",
				15: "Explosion ! [2d×niveau de puissance] de dégâts explosifs centrés sur l’initiateur.",
				16: "Le sort échoue. L’initiateur vieillit de [1d×niveau de puissance] années et perd 1d/1d+2/2d/2d+2/3d PdE selon le niveau de puissance.",
				18: "Le sort échoue. Un démon apparaît et attaque l’initiateur, sauf si ses intentions étaient pures (refaire un jet). Sort de niveau I ou II → démon mineur. III/IV/V → démon moyen / majeur / majeur extrêmement puissant.",
			}
			resultat = read_table(table_resultats, roll("3d"))
			break


	}


	let display = get_id("msg-content")
	display.value += resultat
	send_msg("jet")
}
