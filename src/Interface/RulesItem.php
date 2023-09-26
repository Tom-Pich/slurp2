<?php

namespace App\Interface;

interface RulesItem
{
	public function displayInRules(bool $show_edit_link = false, string $edit_link = null, array $data = []);
}

// float $cost_mult = 0, string $name = "", string $edit_link = "", array $colleges_names = []
// float $cost_mult = 1, string $name = "", string $edit_link = "gestion-listes?req=avdesav", array $unused = []
// $data = [ name => "", cost-mult => ..., colleges-list => ...]