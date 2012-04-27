<?php

require_once '../includes/db.php';

$places_xml = simplexml_load_file('2009_basketball_courts.kml');

$sql = $db->prepare('
	INSERT INTO open_data_app (name, address, longitude, latitude)
	VALUES (:name, :address, :longitude, :latitude)
');

foreach ($places_xml->Document->Placemark as $place) {
	$coords = explode(',', trim($place->Point->coordinates));
	
	$adr = '';
	$name = '';

	foreach ($place->ExtendedData->Data as $civic) {
		if ($civic->attributes()->name == 'Address') {
			$adr = $civic->value;
		}
		if ($civic->attributes()->name == 'Name') {
			$name = $civic->value;
		}
	}

	
	
		$sql->bindValue(':name', $name, PDO::PARAM_STR);
		$sql->bindValue(':address', $adr, PDO::PARAM_STR);
		$sql->bindValue(':longitude', $coords[0], PDO::PARAM_STR);
		$sql->bindValue(':latitude', $coords[1], PDO::PARAM_STR);
		$sql->execute();
}

	//var_dump ($sql->errorInfo());
	
	?>