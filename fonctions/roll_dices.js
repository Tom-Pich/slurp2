/*******************************************************************
**	roll(code) renvoie le résultat d’un code dé type xd(y){+-/*}z
**	y est optionnel : valeur par défaut 6
**	opérateurs et nombres suivants optionnels aussi
**	z peut être un décimal
**	si code = simple nombre → renvoie le nombre entré
*********************************************************************/

function roll(code, return_parameters=false){
	let deg = 0
	let x, y, op, z
	let match = /^(\d+)d(\d{0,3})([+-/*]*)([0-9\.]+)*/.exec(code)
	if (match === null){
			deg = isNaN(parseInt(code)) ? 0 : parseInt(code)
			x = 0, y = "", op="+", z=deg
	}
	else{
		x = match[1]
		y = (match[2] != "") ? match[2] : 6
		op = (match[3] != "") ? match[3] : "+"
		z = (match[4] != undefined && match[4] != "") ? parseFloat(match[4]) : 0
		for(let i = 0; i < x ; i++){deg += Math.floor(Math.random()*y)+1}
		switch(op){
			case "+" : deg += z ; break;
			case "-" : deg -= z ; break;
			case "*" : deg *= z ; break;
			case "/" : deg /= z ; break;
		}
	}
	if(!return_parameters){return deg}
	else{return [deg,x,y,op,z]}
}

/* Sert pour le widget "Jet de dés simple" */
function roll_dices(){
	let code = get_value("jet1")
	let display = get_id("msg-content")
	let result = roll(code, true)
	if(result[0]){
		let x = result[1], y = result[2], op = result[3], z = result[4]
		y = y==6 ? "" : y
		if ((op == "+" || op == "-") && z == 0){op = "" ; z =""}
		display.value += (display.value.length != 0 ? " " : "" ) + x + "d" + y + op + z + " → " + result[0]
		send_msg("jet")
	}
}

/* teste un score avec 3d en gérant les critiques. Si niveaux = true, renvoie -1 / 0 / 1 / 2 pour qualifier succès */
function test_3d(score, niveaux=false){
	critique = false
	let jet = roll("3d")
	let MR = score - jet
	if (MR <= -10 && jet >= 15 || jet == 17 && MR <= -2 || jet == 18){critique = "mauvais"}
	if (MR >= 10 && jet <= 6 || jet == 4 && MR >= 2 || jet == 3){critique = "bon"}
	if (jet == 17 && score >= 17){MR = -1}
	if (jet == 4 && score <= 4){MR = 0}
	if(niveaux){
		if (critique == "mauvais"){return -1}
		else if (critique == "bon"){return 2}
		else {return MR >= 0 ? 1:0}
	}
	else{
		if (critique){return critique}
		else{return MR}
	}
}

/* Sert pour le widget "Jet sous une caractéristique */
function test_3d_table(x){
 	let competence = x.parentNode.children[0].children[0].value
	let score = parseInt(x.parentNode.children[0].children[2].value)
	let modif = parseInt(x.parentNode.children[0].children[3].value) || 0
	score += modif
 	if(!isNaN(score)){var resultat = test_3d(score)}
	if (resultat == "mauvais") {resultat = "échec critique&nbsp;! &#128555;"}
	else if (resultat == "bon") {resultat = "réussite critique&nbsp;! &#128526;"}
	else if (resultat >= 0){resultat = "réussi de " + resultat}
	else{resultat = "raté de " + -resultat}

	if (!isNaN(score) && competence != ""){
		let display = document.getElementById("msg-content")
		display.value += competence + " ("+ score +") – " + resultat		
		send_msg("jet")
	}
	
}