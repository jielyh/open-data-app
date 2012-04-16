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
			+ '<strong>' + longitude + '</strong>'
			+ '<strong>' + latitude + '</strong>'
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
			, animation: google.maps.Animation.DROP
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


 /****************************************************/
  /***** Geolocation **********************************/
  /****************************************************/

  var userMarker;

  // A function to display the user on the Google Map
  //  and display the list of closest locations
  function displayUserLoc (lat, lng) {
    var locDistances = []
      , totalLocs = locations.length
      , userLoc = new google.maps.LatLng(lat, lng);
    ;

    // Create a new marker on the Google Map for the user
    //  or just reposition the already existent one
    if (userMarker) {
      userMarker.setPosition(userLoc);
    } else {
      userMarker = new google.maps.Marker({
        position : userLoc
        , map : map
        , title : 'You are here.'
        , icon : 'images/user.png'
        , animation: google.maps.Animation.DROP
      });
    }

    // Center the map on the user's location
    map.setCenter(userLoc);

    // Create a new LatLon object for using with latlng.min.js
    var current = new LatLon(lat, lng);

    // Loop through all the locations and calculate their distances
    for (var i = 0; i < totalLocs; i++) {
      locDistances.push({
        id : locations[i].id
        , distance : parseFloat(current.distanceTo(new LatLon(locations[i].lat, locations[i].lng)))
      });
    }

    // Sort the distances with the smallest first
    locDistances.sort(function (a, b) {
      return a.distance - b.distance;
    });

    var $dinoList = $('.dinos');

    // We can use the resorted locations to reorder the list in place
    // You may want to do something different like clone() the list and display it in a new tab
    for (var j = 0; j < totalLocs; j++) {
      // Find the <li> element that matches the current location
      var $li = $dinoList.find('[data-id="' + locDistances[j].id + '"]');

      // Add the distance to the start
      // `toFixed()` makes the distance only have 1 decimal place
      $li.find('.distance').html(locDistances[j].distance.toFixed(1) + ' km');

      $dinoList.append($li);
    }
  }

  // Check if the browser supports geolocation
  // It would be best to hide the geolocation button if the browser doesn't support it
  if (navigator.geolocation) {
    $('#geo').click(function () {
      // Request access for the current position and wait for the user to grant it
      navigator.geolocation.getCurrentPosition(function (pos) {
        displayUserLoc(pos.coords.latitude, pos.coords.longitude);
      });
    });
  }

  $('#geo-form').on('submit', function (ev) {
    ev.preventDefault();

    // Google Maps Geo-coder will take an address and convert it to lat/lng
    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({
      // Append 'Ottawa, ON' so our users don't have to
      address : $('#adr').val() + ', Ottawa, ON'
      , region : 'CA'
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          displayUserLoc(results[0].geometry.location.lat(), results[0].geometry.location.lng());
        }
      }
    );
  });

