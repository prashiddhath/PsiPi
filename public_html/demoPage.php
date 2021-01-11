<?php
	$link = new mysqli('localhost','group9','xNs1UQ', 'group9');
	if($link->connect_error) {
		echo '<span style="color:red;">Could not connect to database server:</span><br>';
		echo '<span style="color:red;">'. $link->connect_error .'</span><br>';
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="styleSheet" href="styleSheet.css?v=<?php echo date('his'); ?>">
		<title>PsiPi</title>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.12.4.js"></script>
		<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	</head>
	<body>
		<?php include("header.php");?>

		<section>
			<label for="autocomplete">Select a Physisists Name: </label>
			<input id="searchInput">

			<script>
				var tags = [	<?php
						$result = $link->query("SELECT name FROM Physicists");
						$row = $result->fetch_array(MYSQLI_NUM);
						if ($row) {
							echo '"' . $row[0] . '"';
						}
						while($row = $result->fetch_array(MYSQLI_NUM)) {
							echo ',"' . $row[0] . '"';
						}
						?>
					   ]
				$( "#searchInput" ).autocomplete({
					source: function( request, response ) {
						var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
						response( $.grep( tags, function( item ){
							return matcher.test( item );
						}) );
					}
				});
			</script>
		</section>
	</body>
</html>
