<?php

require_once 'includes/db.php';

// `->exec()` allows us to perform SQL and NOT expect results
// `->query()` allows us to perform SQL and expect results

//creating 'results' variable ($)
$results = $db->query(' 
	SELECT id, name, longitude, latitude
	FROM open_data_app
	
');

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Basketball Courts!</title>
	<script src="js/modernizr-2.5.3.js"></script>
    <link href="css/public.css" rel="stylesheet"/>
</head>
<body>	
	<div class="list">
		<ol class="courts">
			<?php foreach ($results as $location) : ?>	
				<li itemscope itemtype="http://schema.org/TouristAttraction">
					<a href="single.php?id=<?php echo $location['id']; ?>"><?php echo $location['id']; ?></a>
					<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
					<meta itemprop="latitude" content="<?php echo $dino['latitude']; ?>">
					<meta itemprop="longitude" content="<?php echo $dino['longitude']; ?>">
					</span>
				</li>
			<?php endforeach; ?>
		</ol>
    </div>
    
    <div id="map"></div>
	
</body>
</html>


