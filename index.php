<?php



require_once 'includes/db.php';

// `->exec()` allows us to perform SQL and NOT expect results
// `->query()` allows us to perform SQL and expect results

//creating 'results' variable ($)
$results = $db->query(' 
	SELECT id, name, address, longitude, latitude, rate_count, rate_total
	FROM open_data_app
	
');

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Basketball Courts!</title>
    <link href="css/public.css" rel="stylesheet"/>
</head>
<body>	

	<div class="left_side">
    	<img src="images/logo.png" alt="logo basketball courts open data app" >
        <div id="map"></div>
      <!--  <img src="images/basket.png" alt="basketball image"> -->
    </div>
    
    <div class="right_side">
    	<form id="geo-form">
            <input id="adr" placeholder="Address, Intersection, Postal Code, Park">
        </form>
        <span id="geo">Find Me</span>
        <div class="login">
            <a href="admin/index.php">Admin Login</a>
        </div>
        
        <ol class="courts">
            
			<?php foreach ($results as $location) : ?>
				<?php
					if ($location['rate_count'] > 0) {
					$rating = round($location['rate_total'] / $location['rate_count']);
					} else {
					$rating = 0;
				}
			?>
			<li itemscope itemtype="http://schema.org/TouristAttraction" data-id="<?php echo $location['id']; ?>">
				<strong class="distance"></strong>
				<a href="single.php?id=<?php echo $location['id']; ?>" itemprop="name"><?php echo $location['name']; ?></a>
				<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
					<meta itemprop="latitude" content="<?php echo $location['latitude']; ?>">
					<meta itemprop="longitude" content="<?php echo $location['longitude']; ?>">
				</span>
				<meter value="<?php echo $rating; ?>" min="0" max="5"><?php echo $rating; ?> out of 5</meter>
				<ol class="rater">
					<?php for ($i = 1; $i <= 5; $i++) : ?>
						<?php $class = ($i <= $rating) ? 'is-rated' : ''; ?>
						<li class="rater-level <?php echo $class; ?>">★</li>
					<?php endfor; ?>
				</ol>
			</li>
			<?php endforeach; ?>
		</ol>
    </div>

	<script src="js/modernizr-2.5.3.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD1neW38erbHLpvMIDfINGdccoIPME2LRg&sensor=false"></script>
    <script src="js/courts.js"></script>
</body>
</html>


