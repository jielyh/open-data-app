<?php

require_once 'includes/db.php';

// `->exec()` allows us to perform SQL and NOT expect results
// `->query()` allows us to perform SQL and expect results

//creating 'results' variable ($)
$results = $db->query(' 
	SELECT id, name, longitude, latitude
	FROM opendataapp
	ORDER BY name ASC
');

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Basketball Courts!</title>
	<script src="../js/modernizr-2.5.3.js"></script>
    <link href="../css/admin.css" rel="stylesheet"/>    
</head>
<body>	
<a href="add.php">Add a basketball court!</a>	
	<ul>
	
	<?php foreach ($results as $name) : ?>
		<li>
			<a href="single.php?id=<?php echo $name['id']; ?>"><?php echo $name['name']; ?></a>
			&bull;
            <a href="edit.php?id=<?php echo $name['id']; ?>">Edit</a>
			<a href="delete.php?id=<?php echo $name['id']; ?>">Delete</a>
		</li>
	<?php endforeach; ?>
	</ul>
	
</body>
</html>
