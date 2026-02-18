<?php

namespace App\Interface;

interface RulesItem
{
	/**
	 * displayInRules – generate full HTML for displaying in rules
	 *
	 * @param  bool $show_edit_link  show/hide link for editing
	 * @param  array $data overriding default values (depends on rule item type)
	 * @param  bool $lazy lazy loading of description
	 * @return void or displayInRules of parent item
	 */
	public function displayInRules(bool $show_edit_link, string $edit_req, array $data, bool $lazy);
}