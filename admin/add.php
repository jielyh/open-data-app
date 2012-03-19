<?php

require_once 'includes/filter-wrapper.php';

//creating error
$errors = array();

$movie_title = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$release_date = filter_input(INPUT_POST, 'longitude', FILTER_SANITIZE_STRING);
$director = filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_STRING);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (empty($name)) {
		$errors['name'] = true;
	}
	
	if (empty($longitude)) {
		$errors['longitude'] = true;
	}
		if (empty($latitude)) {
		$errors['latitude'] = true;
	}
	
	if (empty($errors)) {
		require_once 'includes/db.php';
		
		$sql = $db->prepare('
			INSERT INTO movies (name,longitude, latitude)
			VALUES (:name, :longitude, :latitude)
		');
		$sql->bindValue(':name', $name, PDO::PARAM_STR);
		$sql->bindValue(':longitude', $longitude, PDO::PARAM_STR);
		$sql->bindValue(':latitude', $latitude, PDO::PARAM_STR);
		$sql->execute();
		
		header('Location: index.php');
		exit;
	}
}

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Add a Movie</title>
    <script src="../js/modernizr-2.5.3.js"></script>
    <link href="../css/admin.css" rel="stylesheet"/>    
</head>
<body>
	
    
	<form method="post" action="add.php">
		<div>
			<label for="movie_title">Movie Title<?php if (isset($errors['movie_title'])) : ?> <strong>is required</strong><?php endif; ?></label>
			<input id="movie_title" name="movie_title" value="<?php echo $movie_title; ?>" required>
		</div>
		<div>
			<label for="release_date">Release Date<?php if (isset($errors['release_date'])) : ?> <strong>is required</strong><?php endif; ?></label>
			<input id="release_date" name="release_date" value="<?php echo $release_date; ?>" required>
		</div>
        <div>
			<label for="director">Director<?php if (isset($errors['director'])) : ?> <strong>is required</strong><?php endif; ?></label>
			<input id="director" name="director" value="<?php echo $director; ?>" required>
		</div>
		<button type="submit">Add</button>
	</form>
	
</body>
</html>
