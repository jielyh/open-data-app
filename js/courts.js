$(document).ready(function() {

	// Create an object that holds options for the GMap
	//can change the zooom level, ROAD map = can change to different viewing maps
	//45.423494,-75.697933 = long and lat for ottawa, coveres city hall
	var gmapOptions = {
		center : new google.maps.LatLng(45.423494,-75.697933)
		, zoom : 13
		, mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	// Create a variable to hold the GMap and add the GMap to the page
	//stick this code and code above, then map will show
	var map = new google.maps.Map(document.getElementById('map'), gmapOptions);

	// Share one info window variable for all the markers
	var infoWindow;

	// Loop through all the places and add a marker to the GMap
	//selecting all li elemtns and sticking it onto the map
	$('.courts li').each(function (i, elem) {
		var name = $(this).find('a').html();

		// Create some HTML content for the info window // adding content into the info window, can add more etc. long and lat
		// Style the content in your CSS
		var info = '<div class="info-window">'
			+ '<strong>' + name + '</strong>'
			+ '</div>'
		;

		// Determine this dino's latitude and longitude
		var longitude = $(this).find('meta[itemprop="longitude"]').attr('content');
		var latitude = $(this).find('meta[itemprop="latitude"]').attr('content');	
		var position = new google.maps.LatLng(latitude, longitude);

		// Create a marker object for this dinosaur
		var marker = new google.maps.Marker({
			//where position --> var pos = new google.maps.LatLng(lat, lng);
			position : position
			//which map assigned to
			, map : map
			, title : name
			//drop your own icon here
			, icon : 'images/ball.png'
			// 2 options: DROP or Bounce (refresh page and see the icons drop in)
			, animation: google.maps.Animation.BOUNCE
		});

		// A function for showing this dinosaur's info window
		//stops the link on the left from gonig to the single page
		function showInfoWindow (ev) {
			if (ev.preventDefault) {
				ev.preventDefault();
			}

			// Close the previous info window first, if one already exists
			if (infoWindow) {
				infoWindow.close();
			}

			// Create an info window object and assign it the content
			infoWindow = new google.maps.InfoWindow({
				content : info
			});

			infoWindow.open(map, marker);
		}

		// Add a click event listener for the marker
		google.maps.event.addListener(marker, 'click', showInfoWindow);
		// Add a click event listener to the list item
		//adding something from outside the map (addDomListener)
		google.maps.event.addDomListener($(this).children('a').get(0), 'click', showInfoWindow);
	});
});
