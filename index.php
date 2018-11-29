<!DOCTYPE html>
<?php include('server.php'); ?>
<?php 
	if (!$_SESSION['username'] || $_SESSION['username'] == "")
		header("location: Users/login.php");
?>
<?php include_once("base.php"); ?>

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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type ="text/css" href="./css/main.css">
	<link rel="stylesheet" type ="text/css" href="./Users/reg_style.css">
</head>
<body>
<?php include_once('Users/header_template.php') ?>
<!-- <div style="margin-left:25%;padding:1px 16px;height:1000px;"> -->
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
	<script 
		src="navbar.js">
	</script>
	<script>
		var vLat, vLong, map;
		var nearStops = null;
		var nearBusStops = null;
		var nearTrainStops = null;
		var marker = null;
		var stop = [];
		var flag = 0;
		var flag2 = 0;
		var flag3 = 0;
		var flag4 = 0;

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
			getBusStops(token);
			getTrainStops(token);
			journey(token);
		});
		request.setRequestHeader('Accept', 'application/json');
		var formData = new FormData();

		for (var key in payload) {
		formData.append(key, payload[key]);
		}

		request.send(formData);


	function journey(token,start,end)
		{
			var body = {
			geometry: {
				type: 'Multipoint',
				coordinates: [[18.512248, -33.895430], [18.416798, -33.912683]]
			},
			omit: {
			
				modes: ["Rail", "LightRail", "ShareTaxi"]
			},
			maxItineraries: 1
			};
			var request = new XMLHttpRequest();
			request.addEventListener('load', function () {
			
			var response = JSON.parse(this.responseText);
			console.log('Response', response);
			
			});
			request.open('POST', 'https://platform.whereismytransport.com/api/journeys', true);
			request.setRequestHeader('Accept', 'application/json');
			request.setRequestHeader('Content-Type', 'application/json');
			request.setRequestHeader('Authorization', 'Bearer ' + token);
			request.send(JSON.stringify(body));
			request.addEventListener('load', function () {
					var response = JSON.parse(this.responseText);
					//console.log(response);
					var coords = new Array();
					var direction = new Array();
					legs = response['itineraries']['0']['legs'];
					for (var i = 0; i < legs.length; i++) {
						direction[i] =legs[i]['directions'];
						coords[i] = legs[i]['geometry']['coordinates']
					}
					direction = response['itineraries']['0']['legs']['0']['directions'];
					
					// coords = response['itineraries']['0']['legs']['0']['geometry']['coordinates']
					console.log('direction', direction);
					console.log('coords', coords);

				});
			
		}


		// -33.944896, 18.472927
		function getTaxiStops(token) {
			if (flag == 0) {
				var request = new XMLHttpRequest();
				request.addEventListener('load', function () {
					var response = JSON.parse(this.responseText);
					//console.log('Response', response);
				});
				console.log(vLat);
				console.log(vLong);
				request.open('GET', 'https://platform.whereismytransport.com/api/stops?point='+vLat+','+vLong+'&modes=ShareTaxi&limit=5', true);
				request.setRequestHeader('Accept', 'application/json');
				request.setRequestHeader('Authorization', 'Bearer ' + token);
				request.addEventListener('load', function () {
					var response = JSON.parse(this.responseText);
					//console.log(response);
					nearStops = response;
				});
				request.send();
				// flag = 1;
			}
		}

			function getBusStops(token) {
			if (flag == 0) {
				var request = new XMLHttpRequest();
				request.addEventListener('load', function () {
					var response = JSON.parse(this.responseText);
					//console.log('Response', response);
				});
				request.open('GET', 'https://platform.whereismytransport.com/api/stops?point='+vLat+','+vLong+'&modes=Bus&limit=5', true);
				request.setRequestHeader('Accept', 'application/json');
				request.setRequestHeader('Authorization', 'Bearer ' + token);
				request.addEventListener('load', function () {
					var response = JSON.parse(this.responseText);
					//console.log(response);
					nearBusStops = response;

				});
				request.send();
				// flag = 1;
			}
		}

		function getTrainStops(token) {
			if (flag == 0) {
				var request = new XMLHttpRequest();
				request.addEventListener('load', function () {
					var response = JSON.parse(this.responseText);
					//console.log('Response', response);
				});
				request.open('GET', 'https://platform.whereismytransport.com/api/stops?point='+vLat+','+vLong+'&modes=Rail,Subway,LightRail&limit=5', true);
				request.setRequestHeader('Accept', 'application/json');
				request.setRequestHeader('Authorization', 'Bearer ' + token);
				request.addEventListener('load', function () {
					var response = JSON.parse(this.responseText);
					//console.log(response);
					nearTrainStops = response;
				});
				request.send();
				// flag = 1;
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

		// funtion plot(map)
		// {
		// 	var point1 = maps.LatLng(-33.89544,18.51227);
		// 	var point2 = maps.LatLng(-33.89553,18.51218);
		// 	var point3 = maps.LatLng(-33.89565,18.51215);

		// // build an array of the points
		// var wps = [{ location: point1 }, { location: point2 }, {location: point3}];

		// // set the origin and destination
		// var org = maps.LatLng ( -33.89192157947345,151.13604068756104);
		// var dest = maps.LatLng ( -33.69727974097957,150.29047966003418);

		// var request = {
		// 		origin: org,
		// 		destination: dest,
		// 		waypoints: wps,
		// 		travelMode: google.maps.DirectionsTravelMode.DRIVING
		// 		};
		// }
		
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
					vLat = position.coords.latitude;
					vLong = position.coords.longitude;
				});
			}
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					console.log("db updated"+"  lat="+vLat+"&long="+vLong+"&user="+"<?php echo($_SESSION["username"]) ?>");
				}
			};
			xhttp.open("POST", "storeLoc.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("GPSUpdate=123&lat="+vLat+"&long="+vLong+"&user="+"<?php echo($_SESSION["username"]) ?>");
			if (nearStops != null && flag4 == 0) {
				//stop = null;
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
			// if (nearStops != null && flag2 == 0) {
			// 	for (var i = 0; i < 5; i++) {
			// 		var coord = new google.maps.LatLng(vLat + (Math.random() * (0.01) - 0.005), vLong + (Math.random() * (0.001) - 0.0005));
			// 		stop[i]=new google.maps.Marker({
			// 			position: coord,
			// 			map: map,
			// 			icon:'taxi.png',
			// 			label: (Math.floor(Math.random() * 5))+' ★______ '+(Math.floor(Math.random() * 10) + 4)+'/14'
			// 		});

			// 		stop[i].setMap(map);
			// 	}
			// 	flag2 = 1;
			// }


			if (nearBusStops != null && flag4 == 0) {
				//stop = null;
				for (var i = 0; i < nearBusStops.length; i++) {
					var pos = nearBusStops[i]['geometry']['coordinates']; //working on this----------------------------------------------------------------------------
					//console.log(nearStops[i]['name']);
					var coord = new google.maps.LatLng(pos[1], pos[0]);
					stop[i]=new google.maps.Marker({
						position: coord,
						map: map
						,icon:'envy.png',
						label: nearBusStops[i]['name']
					});

					stop[i].setMap(map);
				}
				//nearStops = null;
	
			}

			if (nearTrainStops != null && flag4 == 0) {
				//stop = null;
				for (var i = 0; i < nearTrainStops.length; i++) {
					var pos = nearTrainStops[i]['geometry']['coordinates']; //working on this----------------------------------------------------------------------------
					//console.log(nearStops[i]['name']);
					var coord = new google.maps.LatLng(pos[1], pos[0]);
					stop[i]=new google.maps.Marker({
						position: coord,
						map: map
						,icon:'BLOOOO.png',
						label: nearTrainStops[i]['name']
					});

					stop[i].setMap(map);
				}
				//nearStops = null;
				flag4 = 1;
			}
		;}, 1000);

		// function setMapOnAll(map) {
		// 	for (var i = 0; i < markers.length; i++) {
		// 		markers[i].setMap(map);
		// 	}
		// }
		  console.log("1");
    </script>
		<script async defer
		src="https://maps.googleapis.com/maps/api/js?key==initMap">
		console.log("2");
    </script>

	<!-- <?php include_once('footer_template.php'); ?> -->
	<!-- </div> -->
</body>
</html>





