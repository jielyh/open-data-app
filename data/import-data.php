<?php

require_once '../includes/db.php';

$places_xml = simplexml_load_file('2009_basketball_courts.kml');

$sql = $db->prepare('
	INSERT INTO open_data_app (name, address, longitude, latitude)
	VALUES (:name, :address, :longitude, :latitude)
');

foreach ($places_xml->Document->Folder[0]->Placemark as $place) {
	$coords = explode(',', trim($place->Point->coordinates));
	
	$adr = '';

	foreach ($place->ExtendedData->SchemaData->SimpleData as $civic) {
		if ($civic->attributes()->name == 'Address') {
			$adr = $civic;
		}
	}

	
	
		$sql->bindValue(':name', $place, PDO::PARAM_STR);
		$sql->bindValue(':address', $adr, PDO::PARAM_STR);
		$sql->bindValue(':longitude', $coords[0], PDO::PARAM_STR);
		$sql->bindValue(':latitude', $coords[1], PDO::PARAM_STR);
		$sql->execute();
}

	//var_dump ($sql->errorInfo());
	
	?>