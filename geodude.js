
var vLat, vLong;

function initMap() {
	getLocation();
	var map = new google.maps.Map(document.getElementById('map'), {
	  zoom: 8,
	  center: {lat: vLat, lng: vLong}
	});
	var geocoder = new google.maps.Geocoder();

	document.getElementById('submit').addEventListener('click', function() {
	  geocodeAddress(geocoder, map);
	});
  }

  function geocodeAddress(geocoder, resultsMap) {
	var address = document.getElementById('address').value;
	geocoder.geocode({'address': address}, function(results, status) {
	  if (status === 'OK') {
		resultsMap.setCenter(results[0].geometry.location);
		var marker = new google.maps.Marker({
		  map: resultsMap,
		  position: results[0].geometry.location
		});
	  } else {
		alert('Geocode was not successful for the following reason: ' + status);
	  }
	});
	}
	
	function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
	}

	function showPosition(position) {
		vLat = position.coords.latitude;
		vLong =position.coords.longitude;
	}

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap">
    </script>