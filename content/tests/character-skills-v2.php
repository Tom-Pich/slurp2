<?php
// Test compétences proches nouvelle version – défaut = compétence principale
use App\Entity\Character;
use App\Entity\Skill;
$test = new Character(31);
$test->processCharacter(false);
$raw_skills = [
    //["id" => 21, "niv"=> 2], // combat MN
    ["id" => 22, "niv"=>1], // couteau
	//["id" => 28,], // fléau
    ["id" => 24, "niv"=> 3], // épée
    //["id" => 31], // hache
    //["id" => 26, "niv"=>-1], // Esquive
    //["id" => 169, "niv"=>-4], // Acrobatie
    //["id" => 118, "niv"=>3, "label"=>"Biologie* (Génétique +7)"], // Biologie
    //["id" => 71, "niv"=>2, "label"=>"Survie en forêt (Amazonie +2)"], // Survie
    //["id" => 71, "niv"=>1, "label"=>"Survie en montagne (Rocheuse +2)"], // Survie
];
[$proc_skills, $skill_groups, $points, $modifiers] = Skill::processSkills($raw_skills, $test->raw_attributes, $test->attributes, $test->modifiers, $test->special_traits);

?>
<h4>Groupes compétences</h4>
<?php print_r($skill_groups) ?>

<h4 style="margin-block: 1em .5em;">Compétences</h4>
<?php foreach ($proc_skills as $skill){
	echo "<hr>";
	print_r($skill);
} ?>
<hr>

<p class="mt-1">Points : <?= $points ?></p>