import { qs } from "./lib/dom-utils.js";

const personnages = {

	medfan: ["un paysan / artisan", "un voleur", "un assassin", "un magicien", "un devin", "un garde", "un pèlerin", "un noble", "une guilde", "un troubadour", "un marchand", "un roi", "un monstre", "un dieu", "un prêtre", "les PJ", "un scribe", "un enfant", "un gitan", "un guerrier"],

	annees20: ["un ouvrier", "un cambrioleur", "un tueur à gages", "un savant fou", "un directeur de cirque", "un commissaire", "un adorateur", "une personnalité", "la pègre", "un musicien de jazz", "un boutiquier", "une tête couronnée", "une créature", "un dieu", "un médecin", "les PJ", "un chroniqueur", "un dilettante", "un médium", "un colonialiste"],

	contemporain: ["un petit employé", "un maître chanteur", "un terroriste", "un scientifique", "un routier", "un détective privé", "une secte", "un milliardaire", "une organisation criminelle", "un acteur", "une firme d’import-export", "un chef d’etat", "un parapsychologue", "un informaticien", "un chirurgien", "les PJ", "un grand reporter", "un top-model", "un espion", "un militaire"],

	cyberpunk: ["un employé de corpo", "un dealer", "un solo", "un scientifique", "un nomade", "un flic", "une secte", "un corporatiste", "un gang", "une rockstar", "une mégacorpo", "une «huile»", "un androide", "une IA", "un charcudoc", "les PJ", "un média", "un netrunner", "un indic", "un mercenaire"],

	postapocalyptique: ["un bandit", "un récupérateur", "un psychopathe", "un savant fou", "un traître", "un milicien", "un pèlerin", "un leader", "une tribu", "un solitaire", "un marchand", "une amazone", "un mutant", "un médium", "un médecin", "les PJ", "un vieil érudit", "un enfant", "un mécano", "un robot"],

	spaceopera: ["un diplomate", "un pirate", "un aventurier", "un scientifique", "un mercenaire", "un militaire", "une organisation", "un chef de guerre", "un hors-la-loi", "un espion", "une corporation", "un dirigeant politique", "un extraterrestre", "un télépathe", "un médecin", "les PJ", "un technicien", "un chasseur de primes", "un pilote", "un droïd"]

}

const actions = {

	personnages: ["est poursuivi / recherché par", "cherche à nuire", "demande de l’aide à", "recherche / poursuit", "veut tuer / détruire", "veut soudoyer / séduire", "veut (se faire) engager (par)", "se fait passer pour", "trouve / rencontre", "interroge / torture", "s’allie / conspire avec"],

	lieux: ["veut partir / s’évader de", "veut cambrioler / profaner", "veut visiter / s’introduire dans", "veut acheter / se saisir de", "veut construire / installer", "découvre", "veut vendre / se débarrasser de", "veut attaquer / détruire", "se cache / erre dans"]
}

const lieux = {

	medfan: ["un donjon", "un cachot", "un palais", "une ville", "une officine", "une forêt", "un hospice", "un temple", "une maison close", "une nef", "une taverne", "un sanctuaire", "une auberge", "la salle du trône", "une échoppe", "une mine", "un antre de dragon", "un port", "une province", "un scriptorium"],

	annees20: ["un musée", "un bagne", "un palace", "une capitale", "un laboratoire", "une fête foraine", "un hôpital", "une église", "un tripot", "un dirigeable", "un cabaret", "un cimetière", "des catacombes", "un théâtre", "une armurerie", "une fabrique", "un zoo", "un port", "une colonie", "une bibliothèque"],

	contemporain: ["un musée", "une prison", "un grand hôtel", "une métropole", "un laboratoire", "un parc d’attractions", "un hôpital", "une secte", "un casino", "un paquebot", "une boite de nuit", "une morgue", "des égouts", "un cinéma", "un supermarché", "une centrale nucléaire", "un grand monument", "un aéroport", "une base militaire", "une médiathèque"],

	cyberpunk: ["une base militaire", "un pénitencier", "un motel", "une mégapole", "une banque d’organes", "un terrain vague", "un asile psychiatrique", "une néocathédrale", "une salle de jeu", "un spatiocargo", "un club", "une morgue", "des égouts", "un holociné", "un souk", "une usine", "la matrice", "un aéroport", "un Q.G. corporatiste", "un central informatique"],

	postapocalyptique: ["une communauté", "une prison", "un campement", "un ghetto", "un labo miteux", "une autoroute", "un dispensaire", "des ruines", "une arène", "un convoi", "un oasis", "un cimetière", "un bunker", "un ancien cinéma", "un bazar", "un hangar", "une salle d’archives", "le métro", "une zone irradiée", "l’antre d’un érudit"],

	spaceopera: ["une ville", "un bagne", "un satellite d’accueil", "une base spatiale", "un laboratoire", "une planète", "un vaisseau-hôpital", "un vaisseau fantôme", "une base clandestine", "un spatiocargo", "un bar / club", "un cryosanctorium", "un sanctuaire e.t", "un conseil galactique", "un marché E.T.", "une station minière", "un astre inconnu", "un spatioport", "une lune artificielle", "un champ d’astéroïdes"]
}

function generateIdea(univers) {
	let sujet = personnages[univers][Math.floor(Math.random() * personnages[univers].length)];
	sujet = sujet.charAt(0).toUpperCase() + sujet.slice(1);
	const action_type = Math.floor(Math.random() * 2) ? "personnages" : "lieux";
	const verbe = actions[action_type][Math.floor(Math.random() * actions[action_type].length)];
	const complement = action_type === "personnages" ? personnages[univers][Math.floor(Math.random() * personnages[univers].length)] : lieux[univers][Math.floor(Math.random() * lieux[univers].length)];
	let idee = sujet + " " + verbe + " " + complement
	idee = idee.replace("de un", "d’un");
	idee = idee.replace("de une", "d’une");
	idee = idee.replace("de des", "des");
	return idee
}

const universeSelector = qs("[data-role=widget-generateur-idee] [data-role=universe-selector]")
const fireBtn = qs("[data-role=widget-generateur-idee] [data-role=generer-idee]")
const ideaWrapper = qs("[data-role=widget-generateur-idee] [data-role=wrapper-idee]")

fireBtn.addEventListener("click", e => {
	ideaWrapper.innerText=generateIdea(universeSelector.value)
})