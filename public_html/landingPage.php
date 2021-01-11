<!DOCTYPE html>
<html>
	<head>
		<link rel="styleSheet" href="styleSheet.css?v=<?php echo date('his');?>">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<title>PsiPi - Landing Page</title>

		<script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
		<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
	</head>
	<body>
		<?php include("header.php"); ?>
		<section>
			<h2>Disclamer:</h2>
			<p>This website is student lab work and does not necessarily reflect Jacobs University Bremen opinions. Jacobs University Bremen does not endorse this site, nor is it checked by Jacobs University Bremen regularly, nor is it part of the official Jacobs University Bremen web presence.</p>
			<p>For each external link existing on this website, we initially have checked that the target page does not contain contents which is illegal wrt. German jurisdiction. However, as we have no influence on such contents, this may change without our notice. Therefore we deny any responsibility for the websites referenced through our external links from here.</p>
			<p>No information conflicting with GDPR is stored in the server.</p>
			<a href="mainPage.php">Proceed to Site</a>
		</section>

		<div id="mapContainer">
			<h2>You are here:</h2>
			<p style="font-size:12px">(Click marker for IP)</p>
			<div id="map"></div>
			<script>
				var ip;
				var latitude;
				var longitude;
				$.getJSON('https://api.ipgeolocation.io/ipgeo?apiKey=52f8c9819c2440a0a10091d3315617c7', function(data) {
					ip = data.ip;
					latitude = data.latitude;
					longitude = data.longitude;
					var map = L.map('map').setView({lon: longitude, lat: latitude}, 10);

					L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
						maxZoom: 19,
						attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
					}).addTo(map);

					L.marker({lon: longitude, lat: latitude}).bindPopup(ip).addTo(map);
				});
			</script>
		</div>

	</body>
</html>
