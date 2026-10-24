<?php

namespace App\Repository;

abstract class AbstractRepository
{
	public \PDO $db;

	public function __construct()
	{
		global $bdd;
		$this->db = $bdd;
	}

	public function beginTransaction(): void
	{
		$this->db->beginTransaction();
	}

	public function commit(): void
	{
		$this->db->commit();
	}

	public function rollBack(): void
	{
		if ($this->db->inTransaction()) $this->db->rollBack();
	}
}
