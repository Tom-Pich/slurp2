<?php

namespace App\Tests;
use App\Entity\Skill;

class SkillTester{

	public const raw_skills = [
		[ "id" => 116, "niv"=>1, "label"=>"Archéologie" ],
		[ "id" => 22, "niv"=>3, "label"=>"Couteau" ],
		[ "id" => 21, "niv"=>0, "label"=>"Combat MN" ],
	];

	public const raw_attr = [
		"For" => 10, "Dex" => 10, "Int" => 10, "San" => 10, "Per" => 10, "Vol" => 10
	];

	public const attr = [
		"For" => 10, "Dex" => 10, "Int" => 10, "San" => 10, "Per" => 10, "Vol" => 10
	];

	public const modifiers = [
		"Vitesse" => 0
	];

	public const special_traits = [ "mult-memoire-infaillible" => 1 ];

	static public function testSkillProcess(){
		[$processed_skills, $cost, $modifiers] = Skill::processSkills(self::raw_skills, self::raw_attr, self::attr, self::modifiers, self::special_traits);
		//print_r($processed_skills);
		foreach ($processed_skills as $skill){ ?>
			<p><?= $skill["label"] ?> – score&nbsp;: <?= $skill["score"] ?> (expected <?= $skill["niv"] + $skill["base"] ?>) – cost <?= $skill["points"] ?> (expected <?= Skill::niv2cost($skill["niv"], $skill["difficulty"]) ?>)</p>
		<?php } 
	}
}