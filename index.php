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
	<ul>
	
	<?php foreach ($results as $location) : ?>
		<li>
			<a href="single.php?id=<?php echo $location['id']; ?>"><?php echo $location['id']; ?></a>
	
		</li>
	<?php endforeach; ?>
	</ul>
    </div>
	
</body>
</html>


