<!DOCTYPE html>
<?php include_once("base.php"); ?>
<?php include('server.php'); ?>

<?php
	// include('/Users/connect_database.php');
	// $findtaxi = $conn->prepare("SELECT * FROM $dbname.drivers");
	// $findtaxi->execute();
	// $taxicap= $findtaxi->fetchAll();

	// foreach ($taxicap as $tmp)
	// {
	// 	$code_cap = $tmp["capacity"];
	// 	$code_loc = $tmp["loc"];
	// }

?>

<html>

<head>
<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" type ="text/css" href="./Users/reg_style.css">
</head>
<body>
<?php include_once('sizebar_template.php') ?>
<!-- <div style="margin-left:25%;padding:1px 16px;height:1000px;"> -->
	<?php $_SESSION['message'] = "Road Closure: N1 outbound Jip De Jager and Durban Rd" ?>
		<?php if (isset($_SESSION['message'])) : ?>
			<div class="error success">
				<h3> 
					<?php
						echo $_SESSION['message'];
						unset($_SESSION['message']);
					?>
				</h3>
			</div>
		<?php endif ?>
		<?php if (isset($_SESSION['error'])) : ?>
			<div class="error">
				<h3> 
					<?php
						echo $_SESSION['error'];
						unset($_SESSION['error']);
					?>
				</h3>
			</div>
		<?php endif ?>
		</div>
    <div id="map"></div>
		
	<!-- <input id="submit" type="button" value="Geocode"> -->
    <script>
	
		var vLat, vLong, map;
		var nearStops = null;
		var marker = null;
		var stop = [];
		var flag = 0;
		var flag2 = 0;
		var flag3 = 0;

		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function (position) {
				vLat = position.coords.latitude;
				vLong = position.coords.longitude;
			});
		}

		// create a client here: https://developer.whereismytransport.com/clients
		var CLIENT_ID = '';
		var CLIENT_SECRET = '';
		var payload = {
			'client_id': CLIENT_ID,
			'client_secret': CLIENT_SECRET,
			'grant_type': 'client_credentials',
			'scope': 'transportapi:all'
		};
		var request = new XMLHttpRequest();
		request.open('POST', 'https://identity.whereismytransport.com/connect/token', true);
		request.addEventListener('load', function () {
			var response = JSON.parse(this.responseText);
			var token = response.access_token;
			window.token = token;
			getTaxiStops(token);
		});
		request.setRequestHeader('Accept', 'application/json');
		var formData = new FormData();

		for (var key in payload) {
		formData.append(key, payload[key]);
		}

		request.send(formData);

		function getTaxiStops(token) {
			if (flag == 0) {
				var request = new XMLHttpRequest();
				request.addEventListener('load', function () {
					var response = JSON.parse(this.responseText);
					//console.log('Response', response);
				});
				request.open('GET', 'https://platform.whereismytransport.com/api/stops?point='+vLat+','+vLong+'&modes=ShareTaxi&limit=5', true);
				request.setRequestHeader('Accept', 'application/json');
				request.setRequestHeader('Authorization', 'Bearer ' + token);
				request.addEventListener('load', function () {
					var response = JSON.parse(this.responseText);
					//console.log(response);
					nearStops = response;
				});
				request.send();
				flag = 1;
			}
		}
		
    	function initMap() {
			map = new google.maps.Map(document.getElementById('map'), {
			zoom: 15,
			center: {lat: 51.508742, lng: -0.120850},
			mapTypeControl: false
			});
			var geocoder = new google.maps.Geocoder();

			document.getElementById('submit').addEventListener('click', function() {
			geocodeAddress(geocoder, map);
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
			//console.log(vLat + " " + vLong);
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

		setInterval(function(){
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function (position) {
					initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
					if (flag3 == 0) {
						map.setCenter(initialLocation);
						flag3 = 1;
					}
					//console.log(position.coords.latitude + ' ' + position.coords.longitude);
					if (marker != null)
						marker.setMap(null);
					marker = new google.maps.Marker({position: {lat: position.coords.latitude, lng: position.coords.longitude}});
					marker.setMap(map);
				});
			}
			if (nearStops != null) {
				for (var i = 0; i < nearStops.length; i++) {
					var pos = nearStops[i]['geometry']['coordinates']; //working on this----------------------------------------------------------------------------
					//console.log(nearStops[i]['name']);
					var coord = new google.maps.LatLng(pos[1], pos[0]);
					stop[i]=new google.maps.Marker({
						position: coord,
						map: map
						,icon:'stop.png',
						label: nearStops[i]['name']
					});

					stop[i].setMap(map);
				}
				//nearStops = null;
			}
			if (nearStops != null && flag2 == 0) {
				for (var i = 0; i < 20; i++) {
					var coord = new google.maps.LatLng(vLat + (Math.random() * (0.01) - 0.005), vLong + (Math.random() * (0.01) - 0.005));
					stop[i]=new google.maps.Marker({
						position: coord,
						map: map,
						icon:'man.png'
					});

					stop[i].setMap(map);
				}
				flag2 = 1;
			}
		;}, 1000);

		// function setMapOnAll(map) {
		// 	for (var i = 0; i < markers.length; i++) {
		// 		markers[i].setMap(map);
		// 	}
		// }
		  
    </script>
		<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap">
    </script>

	<!-- <?php include_once('footer_template.php'); ?> -->
	<!-- </div> -->
</body>
</html>
