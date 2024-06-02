<?php

namespace App\Repository;

use App\Repository\AbstractRepository;

class CharacterRepository extends AbstractRepository
{
	/**
	 * getCharacter – return raw data from database \
	 * id id_joueur id_groupe Nom Statut Pts Caractéristiques État Calculs MPP \
	 * Avdesav Compétences Sorts Pouvoirs Psi Description Background Notes Portrait 
	 *
	 * @param  int $id
	 * @return ?array
	 */
	public function getCharacterRawData(int $id): ?array
	{
		$query = $this->db->prepare("SELECT * FROM persos WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		if (!$item) {
			return null;
		}
		return $item;
	}
	/**
	 * getCharacterRef – return basic raw data of character
	 *
	 * @param  int $id
	 * @return ?array id, id_joueur, id_groupe, Nom, Statut, Pts, État, Calculs, Description, Portrait
	 */
	public function getCharacterRef(int $id): ?array
	{
		$query = $this->db->prepare("SELECT id, id_joueur, id_groupe, Nom, Statut, Pts, État, Calculs, Description, Portrait FROM persos WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		if (!$item) {
			return null;
		}
		return $item;
	}

	public function getCharacterState(int $id): ?array
	{
		$query = $this->db->prepare("SELECT État FROM persos WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		if (!$item) {
			return null;
		}
		return json_decode($item["État"], true);
		//return $item;
	}

	/**
	 * getCharactersFromGroup – array of ids
	 *
	 * @param  int $group_id
	 * @return array of characters id
	 */
	public function getCharactersFromGroup(int $group_id, bool $only_active = true): array
	{
		if ($only_active){
			$query_string = "SELECT id FROM persos WHERE id_groupe = ? AND Statut NOT IN (\"Archivé\",\"Mort\")";
		} else {
			$query_string = "SELECT id FROM persos WHERE id_groupe = ?";
		}
		$group_membres_id = [];
		$query = $this->db->prepare($query_string);
		$query->execute([$group_id]);
		while ($item = $query->fetch(\PDO::FETCH_ASSOC)) {
			$group_membres_id[] = $item["id"];
		}
		$query->closeCursor();
		return $group_membres_id;
	}

	/**
	 * getCharactersFromUser – array of characters [[id => xx, (Nom => yy)]...]
	 *
	 * @param  int $id user id
	 * @return array of characters
	 */
	public function getCharactersFromUser(int $id, bool $with_name = false, bool $only_active = true): array
	{
		$query_string = $with_name ? "SELECT id, Nom FROM persos WHERE id_joueur = ?" : "SELECT id FROM persos WHERE id_joueur = ?";
		$query_string .= $only_active ? " AND Statut NOT IN (\"Archivé\",\"Mort\")" : "";
		$query = $this->db->prepare($query_string);
		$query->execute([$id]);
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		return $items;
	}
	
	/**
	 * getCharactersFromGM - array like [[id=> xx,]...]
	 *
	 * @param  int $id
	 * @return array of characters id of the GM
	 */
	public function getCharactersFromGM(int $id): array
	{
		$query_string = "SELECT p.id FROM persos p LEFT JOIN groupes g ON p.id_groupe = g.id WHERE g.MJ = ? OR p.id_groupe = 100 OR p.id_groupe = ?";
		$query = $this->db->prepare($query_string);
		$query->execute([$id, 100+$id]);
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		return $items;
	}

	public function getAllCharacters(): array
	{
		$query = $this->db->query("SELECT id FROM persos");
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		return $items;
	}

	public function createCharacter(array $character_data): void
	{
		// (id) id_joueur id_groupe Nom Statut Pts Caractéristiques État Calculs MPP Avdesav Compétences Sorts Pouvoirs Psi Description Background Notes Portrait

		// correcting accented indexes
		$character_data["Caracteristiques"] = $character_data["Caractéristiques"];
		unset($character_data["Caractéristiques"]);
		$character_data["Etat"] = $character_data["État"];
		unset($character_data["État"]);
		$character_data["Competences"] = $character_data["Compétences"];
		unset($character_data["Compétences"]);

		//var_dump($character_data);

		$query = $this->db->prepare("INSERT INTO persos (id_joueur, id_groupe, Nom, Statut, Pts, Caractéristiques, État, Calculs, MPP, Avdesav, Compétences, Sorts, Pouvoirs, Psi, Description, Background, Notes, Portrait) VALUES(:id_joueur, :id_groupe, :Nom, :Statut, :Pts, :Caracteristiques, :Etat, :Calculs, :MPP, :Avdesav, :Competences, :Sorts, :Pouvoirs, :Psi, :Description, :Background, :Notes, :Portrait)");
		$query->execute($character_data);
	}

	/**
	 * updateCharacterPlayer – update character using character editor
	 *
	 * @param  array $character_data sent by character editor
	 * @return void
	 */
	public function updateCharacterPlayer(array $character_data): void
	{
		// id (id_joueur) (id_groupe) Nom (Statut) Pts Caractéristiques (État) (Calculs) MPP Avdesav Compétences Sorts Pouvoirs Psi Description Background Notes Portrait

		// correcting accented indexes
		$character_data["Caracteristiques"] = $character_data["Caractéristiques"];
		unset($character_data["Caractéristiques"]);
		$character_data["Competences"] = $character_data["Compétences"];
		unset($character_data["Compétences"]);

		$query = $this->db->prepare("UPDATE persos SET Nom = :Nom, Pts = :Pts, Caractéristiques = :Caracteristiques, MPP = :MPP, Avdesav = :Avdesav, Compétences = :Competences, Sorts = :Sorts, Pouvoirs = :Pouvoirs, Psi = :Psi, Description = :Description, Background = :Background, Notes = :Notes, Portrait = :Portrait WHERE id = :id");
		$query->execute($character_data);
	}

	/**
	 * updateCharacterPdX – update PdV, PdF etc. in database \
	 * called every time a character is processed to keep PdX up-to-date \
	 * for GM control panel
	 *
	 * @param  array $pdx_data
	 * @return void
	 */
	public function updateCharacterPdX(array $pdx_data)
	{
		$query = $this->db->prepare("UPDATE persos SET Calculs = :Calculs WHERE id = :id");
		$query->execute($pdx_data);
	}

	public function updateCharacterManager(array $character_data)
	{
		// id id_joueur id_groupe (Nom) Statut Pts (Caractéristiques) État (Calculs) (MPP) (Avdesav) (Compétences) (Sorts) (Pouvoirs) (Psi) (Description) (Background) (Notes) (Portrait)

		// correcting accented indexes
		$character_data["Etat"] = $character_data["État"];
		unset($character_data["État"]);

		$query = $this->db->prepare("UPDATE persos SET id_joueur = :id_joueur, id_groupe = :id_groupe, Statut = :Statut, Pts = :Pts, État = :Etat WHERE id = :id");
		$query->execute($character_data);
	}

	public function updateCharacterPdM(int $id, int|string $pdm){
		if(is_int($pdm)){
			// Safe statement because $pdm is int. If normally prepared, $pdm would be handled as string.
			$query = $this->db->prepare("UPDATE persos SET État = JSON_SET(État, '$.PdM', " . $pdm . ") WHERE id = ?");
			$query->execute([$id]);
		} else {
			$query = $this->db->prepare("UPDATE persos SET État = JSON_REMOVE(État, '$.PdM') WHERE id = ?");
			$query->execute([$id]);
		}
		
	}
}
