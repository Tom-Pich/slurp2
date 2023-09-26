// Calculs les effets des blessures (widget blessures)
function calcul_blessure(){
	let liste_deroulante = get_id("bl_names")
	let id_protagoniste = liste_deroulante.selectedIndex
	let nom_protagoniste = liste_deroulante[liste_deroulante.selectedIndex].innerText
	let poids = val_int(get_id("protagoniste" + id_protagoniste).children[1].value)
	let PdVm = val_int(get_id("protagoniste" + id_protagoniste).children[2].value)
	let deg_b = get_value("bl_deg_b")
	let RD = val_int(get_value("bl_RD"))
	let type = get_value("bl_type")
	let type_nom = get_id("bl_type").options[get_id("bl_type").selectedIndex].innerText;
	let balle = ["b0", "b1", "b2", "b3"].includes(type) ? get_value("bl_type_balle") : ""
	let nom_balle_spe = get_id("bl_type_balle").options[get_id("bl_type_balle").selectedIndex].innerText;
	let localisation = get_value("bl_localisation");
	let localisation_nom = get_id("bl_localisation").options[get_id("bl_localisation").selectedIndex].innerText;

	// Variables de travail bien pratiques
	let isInterne =  ["pe", "b0", "b1", "b2", "b3"].includes(type) ? true : false
	let isTranchant = ["tr", "pe", "b0", "b1", "b2", "b3"].includes(type) ? true : false
	let localisation_aleatoire = localisation === "alea" ? true : false

	// Localisation – array localisations dans calculs_degats.js
	if(localisation_aleatoire && type != "exp"){
		let jet_loc = roll("3d")
		localisation = localisations[jet_loc][1]
		localisation_nom = "Localisation aléatoire&nbsp;: " + localisations[jet_loc][0]
	}
	if (type == "exp"){localisation = "torse"; localisation_nom = "Effets généraux"}

	// Détermination des dégâts bruts
	deg_b = roll(deg_b)

	// Dégâts nets
	let deg_net
	if (balle == "bpa") {deg_net = deg_b - RD/2}			 		// balle perce-armure : RD÷2
	else if (balle == "bpc") {deg_net = deg_b - Math.max(2*RD,1)} 	// balle pointe creuse : RD×2 (min 1)
	else {deg_net = deg_b - RD}

	// fonctions utilisées plusieurs fois
	function recul(deg_b, poids, type, balle, RD, PdVm){
		if (isInterne){
			deg_b = Math.min(deg_b, PdVm + RD)		// limite dégâts pour balles et perforant
			if(balle === "std"){deg_b *= 0.5}		// effets ÷2 pour balle standard
			if(balle === "bpa"){deg_b *= 0.25}		// effetx ÷4 pour balle perce-armure
		}
		else if (["mn", "exp"].includes(type)){deg_b *= 2}
		return malus(poids/10, deg_b, 1, 0.125) 				// 0 pour deg = poids/10, ±1 pour ±12,5%
		}
		
	function malus_san(PdVm, deg){return malus(PdVm, deg, 1)}	// 0 pour deg = PdVm, ±1 par ±10% PdVm

	function assommer(PdVm, deg, type){
		if (type == "mn"){return malus(PdVm, deg, 0, 0.05)}		// 0 pour deg = 0, +1 par 5% PdVm
		else if (type == "br"){return malus(PdVm, deg)}			// 0 pour deg = 0, +1 par 10% PdVm
		return malus(PdVm, deg, 0.5) 							// 0 pour deg = 50% PdVm, ±1 par 10%
	}



	// Caractéristiques des localisations
	let effets = {

		torse : {

			rcl : 1,
			deg_eff: function(deg_net, type, PdVm){
						let deg_eff
						if(isInterne){deg_net = Math.min(deg_net, PdVm);}	// limitation balles et perforant
						if(type == "b0"){deg_eff = deg_net*0.75}
						else if(["tr", "b2"].includes(type)){deg_eff = deg_net*1.5}
						else if(["pe", "b3"].includes(type)){deg_eff = deg_net*2}
						else {deg_eff = deg_net}
						return deg_eff
			},
			mort: function(PdVm, deg, type){
				if(deg >= 4*PdVm){return 99}
				return -99
			},
			pdc : function(PdVm, deg, type){
				if (type == "exp"){return assommer(PdVm, deg, type)}
				return -99
			},
			divers : function(PdVm, deg, type) {
						if(type != "exp"){
							let x = Math.random()
							if(isInterne){x -= 0.5}
							let effet_alea = {
								0 : "",
								1 : "blessure invalidante (colonne vertébrale) ou organe vital touché (mort en quelques heures sauf intervention chirurgicale réussie)",
								2 : "blessure invalidante permanente (colonne vertébrale) ou organe vital touché (mort en quelques minutes sauf intervention chirurgicale réussie)",
							}
							if (deg >= PdVm){
								resultats.chute = 99;
								let i = 0
								if (x <= 0.4){i = 2}
								else if (x <= 0.8){i = 1}
								return "sonné 3" + (i ? "&nbsp;; " : "") + effet_alea[i]
							}
							else if (deg >= 0.50*PdVm){return "sonné 2" + (x <= 0.2 ? ("&nbsp;; " + effet_alea[1]) : "")}
							else if (deg >= 0.25*PdVm){return "sonné 1" + (x <= 0.1 ? ("&nbsp;; " + effet_alea[1]) : "")}
						}
						else {
							let effets_explosions = ""
							if (deg >= 2*PdVm) {effets_explosions = "Nombreuses lésions internes. La mort est inévitable en quelques heures, sauf en cas de soins magiques."}
							else if (deg >= PdVm) {effets_explosions = "Tympans déchirés. Jet de <i>San</i>–3 pour éviter d’avoir les poumons déchirés (mort en quelques heures sauf si hospitalisation). Risques importants de séquelles neurologiques (jet de <i>San</i>–3)."}
							else if (deg >= 0.5*PdVm) {effets_explosions = "Jet de <i>San</i>–3 pour chaque tympan. Tympan déchiré en cas d’échec. Jet de <i>San</i> pour éviter d’avoir les poumons déchirés (mort en quelques heures sauf si hospitalisation). Risques importants de séquelles neurologiques (jet de <i>San</i>)."}
							else if (deg >= 0.25*PdVm) {effets_explosions = "Jet de <i>San</i> pour chaque tympan. Tympan déchiré en cas d’échec."}
							let projection = (deg >= poids/10) ? `Le personnage est projeté et subit des dégâts équivalent à une chute de ${Math.round(deg*20/poids)} m. S’il est conscient, il peut tenter un jet d’<i>Acrobatie</i> pour minimiser sa chute.` : ""
							return effets_explosions + " " + projection
						}
			}
		},
		
		coeur : {
			rcl : 1,
			deg_eff : function(deg_net, type, PdVm){
							let deg_eff
							if(["br", "mn"].includes(type)){deg_eff = deg_net}
							else if(["tr"].includes(type)){deg_eff = false}
							else if(["b0"].includes(type)){deg_eff = deg_net*2}
							else if(["pe", "b1"].includes(type)){deg_eff = deg_net*3}
							else if(["b2"].includes(type)){deg_eff = deg_net*4.5}
							else if(["b3"].includes(type)){deg_eff = deg_net*6}
							return deg_eff
					},
			mort: function(PdVm, deg, type){return malus_san(PdVm, deg)},
			pdc : function(PdVm, deg, type){
						if (isInterne){return malus_san(PdVm, deg*2);}
						return -99
					},
			divers : function(PdVm, deg, type) {
						if (deg >= PdVm){resultats.chute = 99 ; return "sonné 3"}
						else if (deg >= 0.5*PdVm){if (resultats.chute < 3) {resultats.chute = 3} ; return "sonné 2"}
						else if (deg >= 0.25*PdVm){return "sonné 1"}}
		},

		cou : {
			rcl : 2,
			deg_eff : function(deg_net, type, PdVm){
				let deg_eff
				if(["mn", "br"].includes(type)){deg_eff = deg_net*2}
				else if(["b0"].includes(type)){deg_eff = deg_net*1.5}
				else if(["tr", "pe", "b1"].includes(type)){deg_eff = deg_net*3}
				else if(["b2"].includes(type)){deg_eff = deg_net*4.5}
				else if(["b3"].includes(type)){deg_eff = deg_net*6}
				return deg_eff},
			mort: function(PdVm, deg, type){
					if(deg >= 4*PdVm){return 99}
					else if (type == "tr" && deg >= 3*PdVm){return 99}
					else if (type == "br" && deg >= 2*PdVm){return 99}
					return -99
				},
			pdc : function(PdVm, deg, type){return -99},
			divers : function(PdVm, deg, type) {
						if (deg >= PdVm){
							resultats.chute = 99 ;
							return "Possibilité de blessure invalidante permanente (colonne vertébrale). Hémorragie très importante et/ou suffocation entraînant une mort rapide."
						}
						else if (deg >= 0.5*PdVm){
							resultats.chute = 99 ;
							let hemorragie = isTranchant && Math.random() <= 0.75 ? "Hémorragie importante." : ""
							return `sonné 3&nbsp;; possibilité de blessure invalidante (colonne vertébrale). ${hemorragie}`
						}
						else if (deg >= 0.25*PdVm){
							let hemorragie = isTranchant && Math.random() <= 0.15 ? "Hémorragie importante." : ""
							return `sonné 2. ${hemorragie}`
						}
					}
		},

		jambe : {
			rcl : 2,
			deg_eff : function(deg_net, type, PdVm){
				let deg_eff
				if(["mn", "br", "tr"].includes(type)){deg_eff = deg_net}
				else if(["b0"].includes(type)){deg_eff = Math.min(deg_net*0.5, PdVm/2)}
				else if(["pe", "b1", "b2", "b3"].includes(type)){deg_eff = Math.min(deg_net, PdVm/2)}
				return deg_eff},
			mort: function(PdVm, deg, type){return -99},
			pdc : function(PdVm, deg, type){return -99},
			divers : function(PdVm, deg, type) {
						if (deg >= seuils_blessures_membres.jambe*PdVm*2){
							resultats.chute = 99 ;
							return "sonné 3&nbsp;; jambe détruite."
						}
						else if (deg >= seuils_blessures_membres.jambe*PdVm){
							if (resultats.chute < 5){resultats.chute = 5} ;
							return "sonné 2&nbsp;; blessure invalidante."}
						else if (deg >= 0.25*PdVm){return "sonné 1"}}
		},

		bras : {
			rcl : 1,
			deg_eff : function(deg_net, type, PdVm){
				let deg_eff
				if(["mn", "br", "tr"].includes(type)){deg_eff = deg_net}
				else if(["b0"].includes(type)){deg_eff = Math.min(deg_net*0.5, PdVm*0.4)}
				else if(["pe", "b1", "b2", "b3"].includes(type)){deg_eff = Math.min(deg_net, PdVm*0.4)}
				return deg_eff},
			mort: function(PdVm, deg, type){return -99},
			pdc : function(PdVm, deg, type){return -99},
			divers : function(PdVm, deg, type) {
						if (deg >= seuils_blessures_membres.bras*PdVm*2){
							let transmis_torse = ""
							if (deg > seuils_blessures_membres.bras*PdVm*2 && Math.random() <= 0.8){
								transmis_torse += `Si le coup était latéral, ${Math.round(deg - 0.8*PdVm)} pts de dégâts sont transmis au torse.`
							}
							return "sonné 3&nbsp;; bras détruit." + transmis_torse
						}
						else if (deg >= seuils_blessures_membres.bras*PdVm){return "sonné 2&nbsp;; blessure invalidante."}
						else if (deg >= 0.25*PdVm){return "sonné 1"}}
		},

		pied : {
			rcl : 0,
			deg_eff : function(deg_net, type, PdVm){
				let deg_eff
				if(["mn", "br", "tr"].includes(type)){deg_eff = deg_net}
				else if(["b0"].includes(type)){deg_eff = Math.min(deg_net*0.5, PdVm*0.33)}
				else if(["pe", "b1", "b2", "b3"].includes(type)){deg_eff = Math.min(deg_net, PdVm*0.33)}
				return deg_eff},
			mort: function(PdVm, deg, type){return -99},
			pdc : function(PdVm, deg, type){return -99},
			divers : function(PdVm, deg, type) {
						if (deg >= seuils_blessures_membres.pied*PdVm*2){
							resultats.chute = 99 ;
							return "sonné 3&nbsp;; pied détruit"}
						else if (deg >= seuils_blessures_membres.pied*PdVm){
							if (resultats.chute < 5){resultats.chute = 5} ;
							return "sonné 2&nbsp;; blessure invalidante."}
						else if (deg >= 0.25*PdVm){return "sonné 1"}}
		},
		
		main : {
			rcl : 0,
			deg_eff : function(deg_net, type, PdVm){
				let deg_eff
				if(["mn", "br", "tr"].includes(type)){deg_eff = deg_net}
				else if(["b0"].includes(type)){deg_eff = Math.min(deg_net*0.5, PdVm*0.25)}
				else if(["pe", "b1", "b2", "b3"].includes(type)){deg_eff = Math.min(deg_net, PdVm*0.25)}
				return deg_eff},
			mort: function(PdVm, deg, type){return -99},
			pdc : function(PdVm, deg, type){return -99},
			divers : function(PdVm, deg, type) {
						if (deg >= seuils_blessures_membres.main*PdVm*2){return "sonné 3&nbsp;; main détruite"}
						else if (deg >= seuils_blessures_membres.main*PdVm){return "sonné 2&nbsp;; blessure invalidante."}
						else if (deg >= 0.25*PdVm){return "sonné 1"}}
		},

		crane : {
			rcl : 2,
			deg_eff : function(deg_net, type, PdVm){
				let deg_eff
				if (deg_net <= PdVm/6) {deg_eff = deg_net}
				else {deg_eff = 4*deg_net - 3*PdVm/6}
				return deg_eff},
			mort: function(PdVm, deg, type){return malus_san(PdVm, deg)},
			pdc: function(PdVm, deg, type){return assommer(PdVm, deg, type)},
			divers : function(PdVm, deg, type) {
						if (deg >= 1){
							resultats.chute = 99 ;
							return "sonné 3&nbsp;; risque important de séquelles permanentes (perte de mémoire, d’<i>Int</i> ou autre effet)."
						}
						else if (deg >= 0.5*PdVm){return "sonné 2&nbsp;; possibilité de blessure invalidante (perte de mémoire, d’<i>Int</i> ou autre effet)."}
						else if (deg >= 0.1*PdVm){return "sonné 1"}}
		},

		visage : {
			rcl : 2,
			deg_eff : function(deg_net, type, PdVm){
				let deg_eff
				if (deg_net <= PdVm/6) {deg_eff = deg_net}
				else {deg_eff = 2*deg_net - PdVm/6}
				return deg_eff},
			mort: function(PdVm, deg, type){return malus_san(PdVm, deg)},
			pdc: function(PdVm, deg, type){return assommer(PdVm, deg, type)},
			divers : function(PdVm, deg, type) {
						if (deg >= PdVm){
							resultats.chute = 99 ;
							let x = Math.random()
							let effet_alea = ""
							if (x <= 0.15){effet_alea = "perte d’un œil"}
							else if (x <= 0.30){effet_alea = "nez cassé ou arraché"}
							else if (x <= 0.45){effet_alea = "dents arrachées"}
							else if (x <= 0.50){effet_alea = "oreille arrachée"}
							else if (x <= 0.65){effet_alea = "machoire cassée ou arrachée"}
							return "sonné 3&nbsp;; cicactrice très visible" + (effet_alea ? ("&nbsp;; " + effet_alea) : "")
						}
						else if (deg >= 0.5*PdVm){
							let x = Math.random()
							let effet_alea = ""
							if (x <= 0.15){effet_alea = "œil touché"}
							else if (x <= 0.30){effet_alea = "nez touché"}
							else if (x <= 0.45){effet_alea = "dents touchées"}
							else if (x <= 0.50){effet_alea = "oreille touchée"}
							else if (x <= 0.65){effet_alea = "machoire fracturée"}
						return "sonné 2" + (effet_alea ? ("&nbsp;; " + effet_alea) : "")
						}
						else if (deg >= 0){return "sonné 1"}}
		},

		oeil : {
			rcl : 2,
			deg_eff : function(deg_net, type, PdVm){
				let deg_eff
				if(isInterne){if (deg_net <= 1) {deg_eff = deg_net} else {deg_eff = 4*deg_net - 3}}
				else {deg_eff = effets.visage.deg_eff(deg_net, type, PdVm)}
				return deg_eff},
			mort: function(PdVm, deg, type){return malus_san(PdVm, deg*1.25)},
			pdc: function(PdVm, deg, type){return assommer(PdVm, deg, type)},
			divers : function(PdVm, deg, type) {
						if (deg >= PdVm){
							resultats.chute = 99 ;
							return "sonné 3&nbsp;; œil détruit et risque important d’autres séquelles permanentes, selon que les dégâts sont infligés au cerveau ou au visage."
						}
						else if (deg >= 0.5*PdVm){return "sonné 2&nbsp;; œil détruit."}
						else if (deg > 0){return "sonné 1 (si l’arme trop large pour pénétrer l’œil) ou sonné 2 et œil détruit"}
						else if (deg == 0){return "sonné 1"}}
		},

		org_gen : {
			rcl : 2,
			deg_eff : function(deg_net, type, PdVm){
				let deg_eff = Math.min(deg_net, PdVm)
				return deg_eff},
			mort: function(PdVm, deg, type){return -99},
			pdc: function(PdVm, deg, type){return -99},
			divers : function(PdVm, deg, type) {
						if (deg >= 0.2*PdVm){return "sonné 3&nbsp;; blessure invalidante permanente."}
						else if (deg >= 0.1*PdVm){return "sonné 3&nbsp;; blessure invalidante."}
						else if (deg >= 0){return "sonné 2"}}
		},

		oreille : {
			rcl : 2,
			deg_eff : function(deg_net, type, PdVm){
				let deg_eff
				if (deg_net <= PdVm/6) {deg_eff = deg_net}
				else {deg_eff = 4*deg_net - 3*PdVm/6}
				return deg_eff},
			mort: function(PdVm, deg, type){return malus_san(PdVm, deg)},
			pdc: function(PdVm, deg, type){return assommer(PdVm, deg, type)},
			divers : function(PdVm, deg, type) {
						if (deg >= 1*PdVm){
							resultats.chute = 99 ;
							return "sonné 3&nbsp;; oreille détruite, risque important de séquelles permanentes (perte de mémoire, d’<i>Int</i> ou autre effet)."
						}
						else if (deg >= 0.5*PdVm){return "sonné 2&nbsp;; oreille détruite, possibilité de blessure invalidante (perte de mémoire, d’<i>Int</i> ou autre effet)."}
						else if (deg >= 0.2*PdVm){return "sonné 2&nbsp;; oreille détruite."}
						else if (deg >= 0.1){return "sonné 1&nbsp;; oreille handicapée"}}
		}

	}

	// ■■■ Process résultats ■■■■■■■■■■■■■■■■■■■■■■■■■■■
	let resultats = {}

	// ■■■ Chute : renvoie le malus au jet de Dex
	resultats.chute = recul(deg_b*effets[localisation].rcl, poids, type, balle, RD, PdVm)

	// ■■■ Dégâts effectifs
	resultats.deg_eff = effets[localisation].deg_eff(deg_net, type, PdVm)
	if (deg_b <= 0 && RD == 0 && !["br", "mn", "exp"].includes(type)) {resultats.deg_eff = 1}
	if (balle == "bpa") {resultats.deg_eff *= 0.5}
	if (balle == "bpc") {resultats.deg_eff *= 2}

	// ■■■ Mort : renvoie le malus au jet de San
	resultats.mort = effets[localisation].mort(PdVm, resultats.deg_eff, type)

	// ■■■ Perte de conscience : renvoie le malus au jet de San
	resultats.pdc = effets[localisation].pdc(PdVm, resultats.deg_eff, type)

	// ■■■ Effets divers : renvoie du texte
	resultats.divers = effets[localisation].divers(PdVm, resultats.deg_eff, type)

	resultats.chute = Math.round(resultats.chute)
	resultats.deg_eff = Math.round(resultats.deg_eff)
	resultats.mort = Math.round(resultats.mort)
	resultats.pdc = Math.round(resultats.pdc)

	// ■■■ Affichage résultats ■■■
	let display = document.getElementById("msg-content")

	if(poids && PdVm){
		let recap_parametres = `<b>Blessure ${nom_protagoniste}</b> ${poids} kg, PdVm ${PdVm}, Dégâts ${lowFirstLetter(type_nom)} ${balle ? " "+nom_balle_spe : ""} ${get_value("bl_deg_b")} = ${deg_b}<br/>
			${localisation_nom} RD ${RD}<br/>`
		display.value += recap_parametres + "<b>Dégâts effectifs&nbsp;:</b> " + Math.max(0,resultats.deg_eff) + "<br/>"
		if (resultats.mort > 5) {display.value += "Mort immédiate&nbsp;!"}
		else {
			if(resultats.mort >= 0) {display.value += "<b>Mort&nbsp;:</b> jet de <i>San</i>" + (resultats.mort > 0 ? ("–" + resultats.mort) : "") + "<br/>"}
			if(resultats.pdc > 5){display.value += "Perte de conscience immédiate<br/>"}
			else if(resultats.pdc >= 0){display.value += "<b>Perte de conscience&nbsp;:</b> jet de <i>San</i>" + (resultats.pdc > 0 ? ("–" + resultats.pdc) : "") + "<br/>"}
			if(resultats.chute > 5 && resultats.pdc <= 5){display.value += "Chute automatique<br/>"}
			else if(resultats.chute >= 0 && resultats.pdc <= 5){display.value += "<b>Chute&nbsp;:</b> jet de <i>Dex</i>" + (resultats.chute > 1 ? ("–" + resultats.chute) : "") + "<br/>"}
			if(resultats.divers !== undefined){display.value += capFirstLetter(resultats.divers)}
		}
	send_msg("jet")
	}

	// Mise à jour des PdV du protagoniste
	if (poids && PdVm && !["main", "jambe", "bras", "pied"].includes(localisation)){
		let PdV = get_id("protagoniste" + id_protagoniste).children[3].value
		if (PdV === ""){PdV = PdVm}
		get_id("protagoniste" + id_protagoniste).children[3].value = PdV - Math.max(0,resultats.deg_eff)

	}

}

// Détermine les effets des seuils de blessures
function effets_seuils_blessures(PdV, PdVm, blessures_membres, resistance_douleur=false, return_details=false){

	PdV = val_int(PdV)
	PdVm = val_int(PdVm)
	resistance_douleur = parseInt(resistance_douleur) || 0
	
	// Transformation du contenu de blessures membres en JSON (voir _general_header.js)
	if(blessures_membres){blessures_membres = toJSON(blessures_membres.toUpperCase())}

	// Dégâts des différents membres
	var deg_bd = blessures_membres["BD"] || 0
	var deg_bg = blessures_membres["BG"] || 0
	var deg_md = blessures_membres["MD"] || 0
	var deg_mg = blessures_membres["MG"] || 0
	var deg_jd = blessures_membres["JD"] || 0
	var deg_jg = blessures_membres["JG"] || 0
	var deg_pd = blessures_membres["PD"] || 0
	var deg_pg = blessures_membres["PG"] || 0

	let niveaux = ""
	let malus = 0

	function calcul_frac(deg, part){
		if (deg == "D"){return -100}
		deg = Math.abs(parseFloat(deg))
		if(isNaN(deg)){deg = 0}
		let frac = Math.round((PdVm*part-deg)/(PdVm*part)*100)
		return frac
	}

 	if (PdVm && (PdV < PdVm || blessures_membres) ){

		if (PdV < PdVm){
			let frac = Math.min(Math.round(PdV/PdVm*100), 100)
			let effets = read_table(seuils_blessures.general, frac+300)
			let effets_qualitatifs = ""
			if (return_details && frac > -100){
				effets_qualitatifs = effets[resistance_douleur + 1]
				malus = effets[resistance_douleur + 3]
			}
			else if (return_details && frac <= -100){
				effets_qualitatifs = effets[0]
				malus = -Infinity
			}
			else {effets_qualitatifs = effets[0]}
			if(effets_qualitatifs){niveaux += "• PdV " + frac + "&nbsp;% : " + effets_qualitatifs + "<br/>"}
		}

		if(blessures_membres !== "erreur de format"){

			let etat_membres = {
				"Bras droit" : [deg_bd, seuils_blessures_membres.bras, "bras"],
				"Bras gauche" : [deg_bg, seuils_blessures_membres.bras, "bras"],
				"Jambe droite" : [deg_jd, seuils_blessures_membres.jambe, "jambe"],
				"Jambe gauche" : [deg_jg, seuils_blessures_membres.jambe, "jambe"],
				"Main droite" : [deg_md, seuils_blessures_membres.main, "main"],
				"Main gauche" : [deg_mg, seuils_blessures_membres.main, "main"],
				"Pied droit" : [deg_pd, seuils_blessures_membres.pied, "pied"],
				"Pied gauche" : [deg_pg, seuils_blessures_membres.pied, "pied"],
			}
			
			for (const [key, value] of Object.entries(etat_membres)) {
				if(etat_membres[key][0]){
					let frac = calcul_frac(etat_membres[key][0], etat_membres[key][1])
					let effets = read_table(seuils_blessures[etat_membres[key][2]], frac+100)
					if(return_details && frac <= 75 && frac >= 0){
						niveaux += `• ${key} ${frac}&nbsp;% ${effets[resistance_douleur + 1] ? ": " + effets[resistance_douleur + 1] : ""}<br/>`
					}
					else {niveaux += `• ${key} ${frac}&nbsp;% ${effets[0] ? ": " + effets[0] : ""}<br/>`}
				}
			}
		}
		
		else{niveaux += "• Blessure aux membres&nbsp;: format non reconnu&nbsp;!"}
	}

	if(return_details) {return [niveaux, malus]}

	return niveaux
}

// Gère le widget Seuils de blessures
function widget_seuils_blessures(){
	let liste_deroulante = get_id("sb_names")
	let id_protagoniste = liste_deroulante.selectedIndex
	let nom_protagoniste = liste_deroulante[liste_deroulante.selectedIndex].innerText
	let PdVm = get_id("protagoniste" + id_protagoniste).children[2].value
	let PdV = get_id("protagoniste" + id_protagoniste).children[3].value
	if(PdV !== ""){PdV = calculate(PdV)}
	else {PdV = PdVm}
	PdV = Math.min(val_int(PdV), PdVm)
	get_id("protagoniste" + id_protagoniste).children[3].value = PdV
	let blessures_membres = get_id("protagoniste" + id_protagoniste).children[5].value

	let niveaux = effets_seuils_blessures(PdV, PdVm, blessures_membres)

	if(niveaux){
		let display = get_id("msg-content")
		display.value += (display.value.length != 0 ? " " : "" ) + "<b>" + nom_protagoniste + "</b><br/>" + niveaux
		send_msg("jet")
	}
}