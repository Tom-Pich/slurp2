function get_id(id){return document.getElementById(id)}

function get_value(id){return document.getElementById(id).value}

// Table = JS object avec keys entiers >= 0 en ordre croissant
// renvoie 1er match x <= key, inégalité stricte si strict = true
function read_table(table, x, strict = false){
	for (const [key, value] of Object.entries(table)) {
		if (strict && x < key){return value}
		else if (!strict && x <= key){return value}
	}
}

function sendDataGet(url, id_response, callback = false){
	let xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200) {
			if (!callback){
				let display = get_id(id_response)
				if (display.tagName === "INPUT"){display.value = this.responseText}
				else {display.innerHTML = this.responseText}
			}
			else {callback(this.responseText)}
	}};
    xhr.open("GET", url);
    xhr.send();
}

// transforme un string vaguement formaté en JS
// séparateur key / value = espace(s) | deux points
// séparateur item = virgule | point-virgule (avec ou sans espace)
function toJSON(str){
	str = "{\"" + str + "\"}"
    str = str.replace(/\s{0,}[,;]\s{0,}/g, "\",\"") // séparateur item = virgule, espacé strippé (g = greedy)
    str = str.replace(/:/g, " ")					// ":"" remplacé par " "
    str = str.replace(/\s{2,}/g, " ")				// espaces multiples remplacés par espace simple
	str = str.replace(/\s/g, "\":\"")				// espaces simples remplacés par ":"

    try{str = JSON.parse(str)}
    catch(e){str = "erreur de format";}

	return str
}

// Renvoie un entier ou 0 si parseInt est un échec
function val_int(x){
	x = parseInt(x)
	if(isNaN(x)){x=0}
	return x
}

// Met la première lettre d’un string en majuscule / minuscule
function capFirstLetter(x){return x.charAt(0).toUpperCase() + x.slice(1);}
function lowFirstLetter(x){return x.charAt(0).toLowerCase() + x.slice(1);}

// renvoie ± 1 par b d’écart relatif entre x et y, zéro à x = a*y, négatif si x < y
function malus(y,x,a=0,b=0.1){return (1/b)*(x/y - a)}

// renvoie le résultat de eval(str) s’il s’agit d’une expression mathématique
function calculate(str){
	str = str.replace(/[^-()\d/*+.]/g, '');
	try{str = eval(str)}
	catch(e){}
	return str
}

function calculate_cell(x){
	let result
	if (x.value !== ""){result = calculate(x.value)}
	if (result !== undefined){x.value = result}
}