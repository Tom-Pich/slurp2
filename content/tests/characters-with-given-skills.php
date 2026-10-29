<?php

global $bdd;

$sql = <<<'SQL'
SELECT id, Nom FROM persos
WHERE JSON_CONTAINS(Compétences, '{"id": 34}')
   OR JSON_CONTAINS(Compétences, '{"id": 40}')
   OR JSON_CONTAINS(Compétences, '{"id": 101}')
   OR JSON_CONTAINS(Compétences, '{"id": 157}')
   OR JSON_CONTAINS(Compétences, '{"id": 192}');
SQL;

$query = $bdd->query($sql);
$characters = $query->fetchAll(\PDO::FETCH_ASSOC);
$query->closeCursor();

foreach($characters as $c){
	//var_dump($c);
	echo $c['id'] . " – " . $c["Nom"];
	echo "<br>";
}

