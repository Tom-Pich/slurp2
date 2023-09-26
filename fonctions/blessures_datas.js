const localisations = {
	3 : ["Main arrière", "main"],
	4 : ["Main avant", "main"],
	5 : ["Crâne", "crane"],
	6 : ["Cou", "cou"],
	7 : ["Visage (ou crâne)", "visage"],
	8 : ["Bras (avant)", "bras"],
	9 : ["Torse", "torse"],
	10 : ["Torse", "torse"],
	11 : ["Torse", "torse"],
	12 : ["Torse", "torse"],
	13 : ["Torse", "torse"],
	14 : ["Jambe (avant)", "jambe"],
	15 : ["Cœur (ou torse)", "coeur"],
	16 : ["Bras (arrière)", "bras"],
	17 : ["Jambe (arrière)", "jambe"],
	18 : ["Jambe (arrière)", "jambe"]
}

const seuils_blessures = {
	general : {
		0 : ["Mort automatique"],
		100 : ["Évanouissement automatique. Jet de <i>San</i>-5 pour ne pas mourir au moment où ce seuil est franchi. Le personnage reste inconscient jusqu’à ce qu’il franchisse le seuil de -100 % PdVm."],
		150 : ["Évanouissement automatique et jet de <i>San</i>-2 pour ne pas mourir au moment où ce seuil est franchi. Le personnage reste inconscient jusqu’à ce qu’il franchisse le seuil de -100 % PdVm."],
		200 : ["Évanouissement automatique et jet de <i>San</i> pour ne pas mourir au moment où ce seuil est franchi. Le personnage reste inconscient jusqu’à ce qu’il franchisse le seuil de -100 % PdVm."],
		300 : [
				"Jet de <i>Vol</i>-3 à chaque round (sans malus si <i>Résistance à la douleur</i>) pour éviter de perdre conscience. Le personnage ne peut pas se tenir debout s’il n’a pas <i>Résistance à la douleur</i>. S’il a <i>Résistance à la douleur</i>, <i>For</i>, <i>Vitesse</i> et jets à -5.<br/>Le personnage peut reprendre conscience ultérieurement, mais ne pourra rien faire et sera semi-conscient jusqu’à ce que ses PdV soient de nouveau positifs.",
				"Jet de <i>Vol</i>-3 à chaque round pour éviter de perdre conscience. Ne peut pas se tenir debout.<br/>Le personnage peut reprendre conscience ultérieurement, mais ne pourra rien faire et sera semi-conscient jusqu’à ce que ses PdV soient de nouveau positifs.",
				"Jet de <i>Vol</i> à chaque round pour éviter de perdre conscience. <i>For</i>, <i>Vitesse</i> et jets à -5.<br/> Le personnage peut reprendre conscience ultérieurement, mais ne pourra rien faire et sera semi-conscient jusqu’à ce que ses PdV soient de nouveau positifs.",
				-Infinity, -5
			],
		325 : [
				"<i>For</i>, <i>Vitesse</i> et jets à -5 (-3 si <i>Résistance à la douleur</i>).",
				"<i>For</i>, <i>Vitesse</i> et jets à -5",
				"<i>For</i>, <i>Vitesse</i> et jets à -3",
				-5, -3
			],
		350 : [
				"<i>For</i>, <i>Vitesse</i> et jets à -3 (-1 si <i>Résistance à la douleur</i>).",
				"<i>For</i>, <i>Vitesse</i> et jets à -3",
				"<i>For</i>, <i>Vitesse</i> et jets à -1",
				-3, -1
			],
		375 : [
				"<i>For</i>, <i>Vitesse</i> et jets à -1 (pas de malus si <i>Résistance à la douleur</i>).",
				"<i>For</i>, <i>Vitesse</i> et jets à -1",
				"",
				-1, 0
			],
		400 : ["", "", "", 0, 0],
	},
	
	bras : {
		0 : ["Bras détruit"],
		100 : ["Blessure invalidante"],
		125 : ["inutilisable même avec <i>Résistance à la douleur</i>", "inutilisable", "inutilisable"],
		150 : ["inutilisable (ou à -3 si <i>Résistance à la douleur</i>)", "inutilisable", "-3 aux actions nécessitant ce bras"],
		175 : ["-3 aux actions nécessitant ce bras (sauf si <i>Résistance à la douleur</i>)", "-3 aux actions nécessitant ce bras", ""],
		200 : [""],
	},

	jambe : {
		0 : ["Jambe détruite"],
		100 : ["Blessure invalidante"],
		125 : ["inutilisable même avec <i>Résistance à la douleur</i>", "inutilisable", "inutilisable"],
		150 : ["inutilisable (ou <i>Boiteux</i> si <i>Résistance à la douleur</i>)", "inutilisable", "<i>Boiteux</i>"],
		175 : ["<i>Boiteux</i> (sauf si <i>Résistance à la douleur</i>)", "<i>Boiteux</i>", ""],
		200 : [""],
	},

	main : {
		0 : ["Main détruite"],
		100 : ["Blessure invalidante"],
		125 : ["inutilisable même avec <i>Résistance à la douleur</i>", "inutilisable", "inutilisable"],
		150 : ["inutilisable (ou -3 si <i>Résistance à la douleur</i>)", "inutilisable", "-3 aux actions nécessitant cette main"],
		175 : ["-3 aux actions nécessitant cette main (sauf si <i>Résistance à la douleur</i>)", "-3 aux actions nécessitant cette main", ""],
		200 : [""],
	},

	pied : {
		0 : ["Pied détruit"],
		100 : ["Blessure invalidante"],
		125 : ["inutilisable même avec <i>Résistance à la douleur</i>", "inutilisable", "inutilisable"],
		150 : ["inutilisable (ou <i>Boiteux</i> si <i>Résistance à la douleur</i>)", "inutilisable", "<i>Boiteux</i>"],
		175 : ["<i>Boiteux</i> (sauf si <i>Résistance à la douleur</i>)", "<i>Boiteux</i>", ""],
		200 : [""],
	},
}

const seuils_blessures_membres = {
	"bras" : 0.4,
	"jambe" : 0.5,
	"main" : 0.25,
	"pied" : 0.33
}