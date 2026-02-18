<?php

namespace App\Repository;

abstract class AbstractRepository
{
	public \PDO $db;

	public function __construct(){
		global $bdd;
		$this->db = $bdd;
	}
}