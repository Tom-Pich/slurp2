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
		let display = get_id("msg-input")
		display.value += "Explosion " + deg_ref + " – Blast " + frac_blast + "&nbsp;% – Éclats " + frac_frag + "&nbsp;%<br/>" +
			"Dégâts blast&nbsp;: " + deg + "&nbsp;pts&nbsp;; nbre éclats&nbsp;: " + nbr_eclats
		send_msg("jet")
	}
}