<?php

namespace App\Generator;

use App\Lib\TableReader;
use App\Lib\AiService;

class WildGenerator
{

	public const pre_prompt = "Tu es le meneur d'un jeu de rôle médiéval-fantastique low-fantasy. ";
	public const post_prompt = " Style sobre, pas de clichés. Réponds uniquement avec la description.";

	public const herbs = [
		"Cassidre dorée",
		"Pourprine à petites feuilles",
		"Faux-avoine",
		"Mandragone violette",
		"Baulemoisse"
	];

	// dans les couloirs d’un grand château de Paorn
	public const castle_corridor = [
		"deux servantes portant des draps, un seau et un balai",
		"deux femmes nobles, l'une plus âgée que l'autre, discutant à voix basse",
		"un page qui court, manifestement pressé de remettre un message",
		"un valet qui astique laborieusement les chandeliers en laiton du couloir",
		"un intendant en robe sombre, un registre sous le bras, qui compte et recompte quelque chose à mi-voix",
		"trois gardes en patrouille, l'air ennuyé, leurs armures cliquetant sur les dalles",
		"un cuisinier hors de son élément, cherchant visiblement une livraison égarée",
		"un noble d'âge mûr qui marche seul, les mains dans le dos, plongé dans ses pensées",
		"une femme de chambre qui s'arrête le temps de replacer un tableau légèrement de travers",
		"deux apprentis écrivains portant chacun une pile de parchemins, se disputant à voix basse",
		"un vieux chambellan qui inspecte l'alignement des torchères avec une mine sévère",
		"un musicien portant un luth, qui cherche la salle où il doit jouer ce soir",
		"un alchimiste chargé d'une caisse de fioles, qui avance avec une prudence exagérée",
		"deux écuyers qui comparent leurs équipements en marchant, fiers et un peu bruyants",
		"une servante agenouillée qui frotte une tache sur le sol avec obstination",
		"un noble jeune et élégant qui flâne, manifestement sans occupation particulière",
		"un prêtre en habits de cérémonie, qui murmure une prière en longeant le mur",
		"deux cuisinières qui rentrent d'une course au marché, les paniers encore pleins",
		"un garçon d'écurie, perdu, qui n'ose pas demander son chemin",
		"une dame de compagnie qui cherche sa maîtresse, l'air légèrement affolé",
	];

	// personnalités rencontrées dans un grand château de Paorn
	public const castle_personnality = [
		"Gregorius, secrétaire et archiviste — robe de laine brune usée, taches d'encre sur les doigts. Nerveux, parle vite ; très au courant de tout mais craint de trop en dire.",
		"Ruprecht Joris, chambellan — pourpoint de velours bleu nuit, chaîne de fonctions dorée. Cérémonieux et condescendant, considère les PJ comme des importuns s'ils n'ont pas de titre.",
		"Anselm Govert, collecteur des impôts provinciaux — manteau de voyage encore poussiéreux, sacoche de cuir usée. Pragmatique et vaguement cynique, curieux de tout ce qui pourrait l'avantager.",
		"Theodosius Rutger, conseiller juridique du seigneur — toge noire à col blanc, parchemin roulé sous le bras. Pèse chaque mot et élude les questions directes derrière des formules légales.",
		"Floris Tankred, noble en visite et vassal d'un fief voisin — pourpoint brodé vert et or, épée de cérémonie gravée. Affable en surface, calculateur en dessous ; cherche à savoir ce qui se passe au château.",
		"Sigismun Balduin, trésorier de la province — robe de brocart gris perle, clés au ceinturon. Parle bas et avec prudence ; a manifestement peur de confier quelque chose de compromettant.",
		"Reinhard Cornelius, officier de justice chargé des enquêtes — tabard aux couleurs de la province, regard dur. Observateur et peu causant, évalue les PJ avec attention ; peut devenir allié ou obstacle.",
		"Albertus Hannes, chapelain du château — habit de prêtre sobre, croix d'argent, mains toujours jointes. Doux et bienveillant mais retenu ; connaît des secrets de confession qu'il ne divulguera pas.",
		"Kristofer Lorenz, maître des écuries et intendant des approvisionnements — veste de cuir épais, bottes hautes. Franc et direct, peu impressionné par les titres ; bavard si on le met à l'aise.",
		"Hugues Diderik von Tarwen, noble de passage en attente d'une audience — costume de voyage de qualité, armes portées ostensiblement. Impatient et irritable ; pourrait raconter ce qu'il a vu si on l'écoute.",
		"Gerrit Hubrecht, régisseur des domaines agricoles — vêtements de bon drap mais simples, mains calleuses. Terre-à-terre et peu à l'aise dans les intrigues ; dit ce qu'il pense sans saisir les sous-entendus.",
		"Hildegard Elsbet, dame de compagnie de la châtelaine et secrétaire informelle — robe de lin gris bleuté, petit carnet toujours sur elle. Discrète et loyale envers sa maîtresse, détourne poliment les questions sensibles.",
		"Geertruda Kunegunde, gouvernante en chef des servantes — robe noire sévère, tablier blanc amidonné, trousseau de clés à la ceinture. Autoritaire et méfiante, protège ses subordonnées avec fermeté.",
		"Maximian Eckeman, héraut du seigneur — tabard aux armes du seigneur, bâton de fonctions. Formel et procédurier ; courtois si on respecte les formes, hostile sinon.",
		"Rudolf Okkert, représentant d'un puissant marchand de la ville — manteau de velours usé mais de qualité, chaîne en or discrète. Sociable et curieux, peut proposer des échanges de bons procédés.",
		"Valerian Roelof, ancien commandant militaire retraité au château — manteau militaire soigneusement entretenu, cicatrice sur la joue. Calme et économe de ses mots ; respecte la compétence et peut devenir un allié précieux.",
		"Benedikta Johanna, épouse d'un conseiller, présente comme hôtesse — robe de fête bordeaux et crème, bijoux de famille, coiffe élaborée. Mondaine et bavarde, colporte volontiers les rumeurs si on la flatte.",
		"Theophil Siegfren, émissaire d'un autre seigneur en mission diplomatique — tenue sobre aux couleurs d'une autre maison noble, sceau visible à la ceinture. Poli et mesuré, observe plus qu'il ne parle.",
	];

	static function generateResult(array $parameters)
	{
		$category = $parameters["category"];
		$ai = new AiService($_ENV["GEMINI_KEY"]);
		if ($category === "books") {
			// peut-être générer un thème aléatoire avant (histoire, traité technique, géographie, légendes, théologie...) ?
			$prompt = "Génère une courte description d’un livre (250 à 300 caractères) en précisant son titre, son auteur et son sujet.";
			$book = $ai->ask(self::pre_prompt . $prompt . self::post_prompt);
			return $book;
		}
		if (!defined("self::$category")) return "Catégorie non valide";
		$result = TableReader::pickResult(constant("self::$category"));
		return $result;
	}
}
