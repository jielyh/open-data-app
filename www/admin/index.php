<?php
require_once'../users.php';

if (!user_is_signed_in()) {
	header('Location: sign-in.php');
	exit;	
}


require_once '../includes/db.php';

// `->exec()` allows us to perform SQL and NOT expect results
// `->query()` allows us to perform SQL and expect results

//creating 'results' variable ($)
$results = $db->query(' 
	SELECT id, name, longitude, latitude
	FROM open_data_app
	ORDER BY id ASC
');

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Basketball Courts!</title>
	<script src="../js/modernizr-2.5.3.js"></script>
    <link href="../css/public.css" rel="stylesheet">    
</head>
<body>	
	<div class="buttons-css">
    	<a href="../index.php">Home</a>
    </div>
    <div class="buttons-css">
        <a href="add.php">Add a basketball court!</a>
    </div>
    <div class="buttons-css">
        <a href="sign-out.php">Sign Out</a>	
    </div>
	<ul class="name insingle">
	
	<?php foreach ($results as $var): ?>
		<li>
			<a href="../single.php?id=<?php echo $var['id']; ?>"><?php echo $var['id'] . $var['name']; ?></a>
            <a href="edit.php?id=<?php echo $var['id']; ?>">Edit</a>
			<a href="delete.php?id=<?php echo $var['id']; ?>">Delete</a>
		</li>
	<?php endforeach; ?>
	</ul>
    
    <footer>Copyright 2012, jielyh.com</footer>
   
	
</body>
</html>
