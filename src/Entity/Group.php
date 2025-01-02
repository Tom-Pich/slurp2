<?php

namespace App\Entity;

use App\Repository\GroupRepository;

class Group
{
	public ?int $id;
	public string $name;
	public int $id_gm;

	public function __construct(array $data = [])
	{
		/* $this->id = $data["id"] ?? 0;
		if($this->id){
			$this->name = $data["Nom"];
			$this->id_gm = $data["MJ"] ?? 0;
		} */
		$this->id = $data["id"];
		$this->name = $data["Nom"];
		$this->id_gm = $data["MJ"] ?? 0;
	}

	public static function processGroupsSubmit($post)
	{
		foreach ($post["groupes"] as $id => $group) {
			$group["id"] = (int) $id;
			$group["Nom"] = strip_tags(trim($group["Nom"]));
			$group["MJ"] = (int) $group["MJ"];

			$repo = new GroupRepository;
			if ($group["id"]) {
				$repo->updateGroup($group);
			} elseif ($group["Nom"]) {
				unset($group["id"]);
				$repo->createGroup($group);
			}
		}
	}
}
