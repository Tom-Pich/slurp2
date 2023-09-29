// Widget dégâts objet
function calcul_degats_objet() {
	// Récupération des entrées du formulaire
	let PdSm = parseInt(get_value("do_pdsm"))
	let PdS = get_value("do_pds")
	let integrite = get_value("do_integ")
	let RD = parseInt(get_value("do_rd"))
	let code = get_value("do_deg")
	let type = get_value("do_type_deg")
	let type_nom = get_id("do_type_deg").options[get_id("do_type_deg").selectedIndex].innerText;
	let objet = get_value("do_type_objet")
	let orientation = get_value("do_orientation")

	// Tirage dégâts bruts et calcul dégâts net
	let deg_b = parseInt(roll(code))
	let deg_n = Math.max(deg_b - RD,0)
	
	// Dégâts qualitatifs
	let niveau_degats
	if		(deg_n == 0)		{niveau_degats = [0,"aucun"]}
	else if (deg_n < 0.1*PdSm)	{niveau_degats = [1, "très légers"]}	// <  10 % : Très légers
	else if (deg_n < 0.25*PdSm)	{niveau_degats = [2, "légers"]}			// <  25 % : Légers
	else if (deg_n < 0.5*PdSm)	{niveau_degats = [3, "moyens"]}			// <  50 % : Moyens
	else if (deg_n < PdSm)		{niveau_degats = [4, "graves"]}			// <  100 % : Graves
	else if (deg_n < 2*PdSm)	{niveau_degats = [5, "très graves"]}	// <  200 % : Très graves
	else 						{niveau_degats = [6, "extrême"]}		// Au-delà : Extrêmes

	// État actuel
	if(!PdS){PdS = PdSm}
	if (!["tr-loc"].includes(type)){PdS -= deg_n}
	document.getElementById("do_pds").value = PdS
	let niveau_PdS
	if(PdS <= -PdSm )			{niveau_PdS = [5, "Détruit"]}	// <= -100 % : Détruit
	else if(PdS <= 0)			{niveau_PdS = [4, "Hors-service"]}	// <= 0 : Hors-service
	else if(PdS <= 0.5*PdSm)	{niveau_PdS = [3, "Gravement endommagé"]} 	// <= 50% : Gravement endommagé
	else if(PdS <= 0.75*PdSm)	{niveau_PdS = [2, "Moyennement endommagé"]}	// <= 75% : Moyennement endommagé
	else if(PdS <= 0.9*PdSm)	{niveau_PdS = [1, "Légèrement endommagé"]}	// <= 90% : Légèrement endommagé
	else 						{niveau_PdS = [0, "OK"]}	// Au-dessus : Pas affecté
	
	// Effets secondaires (nombres)
	let n_effets_sec = 0
	if(["tr-loc"].includes(type)){if (Math.random() < 0.50){n_effets_sec = 1}} // Dégâts très localisés : 50% d’avoir un effet secondaire
	else{n_effets_sec = Math.trunc(1.2*niveau_degats[0]*(Math.random())^0.5)}
	if (niveau_PdS[0] >= 4){n_effets_sec = 0}
	
	// Localisation et gravité effets secondaires
	let effets_sec = []

	if(n_effets_sec && objet != "0"){

		for(let i = 0 ; i < n_effets_sec ; i++){
			if(table_effets_secondaires[objet][orientation] !== undefined) {var localisation = read_table(table_effets_secondaires[objet][orientation], roll("1d"))}
			else if(table_effets_secondaires[objet] !== undefined) {var localisation = read_table(table_effets_secondaires[objet], roll("1d"))}
			let test_integrite = test_3d(integrite, true)
			let niv_deg_localisation = niveau_degats[0] - test_integrite
			if (localisation !== undefined) {effets_sec.push([localisation, niv_deg_localisation])}
		}
	}
	
	// Affichage
	let effets_degats = document.getElementById("msg-input")
	let display = "<b>Dégâts à un objet</b><br/>"
	display += "PdSm " + PdSm + "&nbsp;; PdS " + PdS + "&nbsp;; Intégrité " + integrite + "&nbsp;; RD " + RD +
	"<br/> Dégâts " + code + " – " + type_nom + "&nbsp;; " + objet + " (" + orientation + ")<br/>"
	display += "<b>Dégâts reçus&nbsp;:</b> " + niveau_degats[1] + "<br/>"
	display += "<b>État&nbsp;:</b> " + niveau_PdS[1] + "<br/>"
	if(effets_sec.length){
		for (let localisation of effets_sec){display += "• " + localisation[0] + " niv. " + localisation[1] + "<br/>"}
	}
	effets_degats.value = display
	if(PdSm && code){send_msg("jet")}

}

// Widget dégâts collision
function collision(){
	let PdSm = parseInt(document.getElementById("collision_pdsm").value)
	let gravite = parseInt(document.getElementById("collision_gravite").value)
	let gravite_nom = document.getElementById("collision_gravite").options[document.getElementById("collision_gravite").selectedIndex].innerText;
	let degats

	switch(gravite){
		case 1 : degats = Math.round((15 + roll("3d"))/100*PdSm); break
		case 2 : degats = Math.round((40 + roll("3d"))/100*PdSm); break
		case 3 : degats = Math.round((90 + roll("3d"))/100*PdSm); break
		case 4 : degats = Math.round((180 + roll("6d"))/100*PdSm); break
		case 5 : degats = "véhicule détruit"; break
		default : degats = 0
	}
	
	// Affichage résultats
	if(PdSm){
		let display = get_id("msg-input")
		display.value += "<b>Collision</b> " + gravite_nom + "&nbsp; PdSm " + PdSm + "<br/>"
		display.value += "Dégâts&nbsp;: " + degats
		send_msg("jet")
	}
}

let table_effets_secondaires = {

		Voiture : {
			"Avant" : {2 : "Moteur" , 4 : "Occupant", 5 : "Équipement divers", 6 : "Roue"},
			"Latéral" : {1 : "Moteur", 2 : "Occupant", 3 : "Porte", 4 : "Roue", 5 : "Équipement divers", 6 : "Réservoir"},
			"Arrière" : {2 : "Occupant" , 3 : "Équipement divers", 4 : "Roue", 5 : "Réservoir"}
		},
		
		Moto : {
			"Avant" : {2 : "Roue" , 4 : "Fourche" , 6 : "Conducteur"},
			"Latéral" : {1 : "Roue", 2 : "Fourche", 3 : "Réservoir", 4 : "Moteur", 5 : "Équipement divers", 6 : "Conducteur"},
			"Arrière" : {2 : "Roue", 5 : "Conducteur", 6 : "Équipement divers"}
		},

		Robot : {1 : "Membre manipulateur", 2 : "Dispositif de locomotion", 3 : "Système informatique central", 4 : "Système sensoriel", 5 : "Batterie", 6 : "Armement/outillage"},

		Quadricoptère : {2 : "Hélice", 4 : "Pilote", 5 : "Batterie", 6 : "Équipement divers"},

}