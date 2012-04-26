<?php

//creating variable called id, grabbing id from query string in the url
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);


//if ID is empty then send back to index
if (empty($id)) {
	header('Location: index.php');
	exit;
}

// Only connect to the database if there is an ID, becuse this is after the above if-statement
// Without an ID there is no point connecting to the database

//
require_once 'includes/db.php';

require_once 'includes/functions.php';

require_once 'includes/filter-wrapper.php';

// ->prepare() allows us to execute SQL with user input
$sql = $db->prepare('
	SELECT id, longitude, latitude, rate_count, rate_total
	FROM open_data_app
	WHERE id = :id 
');

// ->bindValue() lets us fill in placeholders in our prepared statement
// :id is a placeholder for us to SECURELY put information from the user

//making sure that people cannot stick a variable in there
$sql->bindValue(':id', $id, PDO::PARAM_INT);

// Performs the SQL query on the database
$sql->execute();

// Gets the results from the SQL query and stores them in a variable
// ->fetch() gets a single result
// ->fetchAll() gets all the possible results

$results = $sql->fetch();

// Redirect the user back to the homepage if there are no database results
// No results will happen if they change the ?id=4 to include an ID that doesn't exist
if (empty($results)) {
	header('Location: index.php');
	exit; // Stop the PHP compiler right here and immediately redirect the user
}

$title = $results['id'];

if ($results['rate_count'] > 0) {
	$rating = round($results['rate_total'] / $results['rate_count']);
} else {
	$rating = 0;
}

$cookie = get_rate_cookie();


?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $results['id']; ?> &middot; Basketball Courts 2009</title>
    <link href="css/public.css" rel="stylesheet">
</head>
<body>
	<div class="insingle">
        <h1><?php echo $results['id']; ?></h1>
        <dl>
		<dt>Average Rating</dt><dd><meter value="<?php echo $rating; ?>" min="0" max="5"><?php echo $rating; ?> out of 5</meter></dd>
		<dt>Longitude</dt><dd><?php echo $results['longitude']; ?></dd>
		<dt>Latitude</dt><dd><?php echo $results['latitude']; ?></dd>
	</dl>
	
	<?php if (isset($cookie[$id])) : ?>
	
	<h2>Your rating</h2>
	<ol class="rater rater-usable">
		<?php for ($i = 1; $i <= 5; $i++) : ?>
			<?php $class = ($i <= $cookie[$id]) ? 'is-rated' : ''; ?>
			<li class="rater-level <?php echo $class; ?>"></li>
		<?php endfor; ?>
	</ol>
	
	<?php else : ?>
	
	<h2>Rate</h2>
	<ol class="rater rater-usable">
		<?php for ($i = 1; $i <= 5; $i++) : ?>
		<li class="rater-level"><a href="rate.php?id=<?php echo $results['id']; ?>&rate=<?php echo $i; ?>"></a></li>
		<?php endfor; ?>
	</ol>
    <?php endif; ?>
        <div class="login buttons-css">
        	<a href="index.php">Go Back</a>
    	</div>
        <div class="login buttons-css">
        	<a href="admin/index.php">Admin Page</a>
    	</div>
    </div>
    
</body>
</html>
