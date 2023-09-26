<?php

namespace App\Repository;

use App\Repository\AbstractRepository;
use App\Entity\User;

class UserRepository extends AbstractRepository
{
	/**
	 * getUser
	 *
	 * @param  int $id
	 * @return ?User
	 */
	public function getUser(int $id): ?User
	{
		$query = $this->db->prepare("SELECT * FROM " . TABLE_PREFIX . "utilisateurs WHERE id = ?");
		$query->execute([$id]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		if (!$item) {
			return null;
		}

		$user = new User($item);
		return $user;
	}

	/**
	 * getAllUsers
	 *
	 * @return array Array of User Objects
	 */
	public function getAllUsers(): array
	{
		$query = $this->db->query("SELECT * FROM " . TABLE_PREFIX . "utilisateurs");
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$users = [];
		foreach ($items as $item) {
			$users[] = new User($item);
		}
		return $users;
	}

	/**
	 * getUserByLogin
	 *
	 * @param  string $login
	 * @return ?User
	 */
	public function getUserByLogin(string $login): ?User
	{
		$query = $this->db->prepare("SELECT * FROM " . TABLE_PREFIX . "utilisateurs WHERE login = ?");
		$query->execute([$login]);
		$item = $query->fetch(\PDO::FETCH_ASSOC);
		$query->closeCursor();

		if (!$item) {
			return null;
		}

		$user = new User($item);
		return $user;
	}

	public function getGMUsers(): array
	{
		$query = $this->db->query("SELECT * FROM utilisateurs WHERE Statut > 1");
		$items = $query->fetchAll(\PDO::FETCH_ASSOC);
		$query->closeCursor();
		$users = [];
		foreach ($items as $item) {
			$users[] = new User($item);
		}
		return $users;
	}

	public function updateUser(User $user): void
	{
		//  id, login, mdp, Statut
		$query = $this->db->prepare("UPDATE " . TABLE_PREFIX . "utilisateurs SET login = ?, mdp = ?, Statut = ? WHERE id = ? ");
		$query->execute([$user->login, $user->password, $user->status, $user->id]);
		$query->closeCursor();
	}

	public function createUser(User $user): void
	{
		$query = $this->db->prepare ("INSERT INTO " . TABLE_PREFIX . "utilisateurs (login, mdp, Statut) VALUES (?, ?, ?)") ;
		$query->execute([$user->login, $user->password, $user->status]);
		$query->closeCursor();
	}

	public function deleteUser(int $id): void{
		$query = $this->db->prepare ("DELETE FROM " . TABLE_PREFIX . "utilisateurs WHERE id = ?") ;
		$query->execute([$id]);
		$query->closeCursor();
	}
}
