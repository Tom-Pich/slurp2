<?php

use App\Repository\EquipmentRepository;

$repo = new EquipmentRepository;
$items = $repo->getCharacterEquipment(27);

echo "<pre>";
echo $carried_weight;

foreach ($items as $i){
	echo json_encode($i, JSON_UNESCAPED_UNICODE) . "<br>";
}