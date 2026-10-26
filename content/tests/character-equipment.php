<?php

use App\Repository\EquipmentRepository;

$repo = new EquipmentRepository;
$items = $repo->getOrphanEquipment();

echo "<pre>";

foreach ($items as $i){
	echo json_encode($i, JSON_UNESCAPED_UNICODE) . "<br>";
}