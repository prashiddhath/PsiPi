<?php
	require("tools.php");

	$link = new mysqli('localhost','group9','xNs1UQ', 'group9');
	if($link->connect_error) {
		echo '<span style="color:red;">Could not connect to database server:</span><br>';
		echo '<span style="color:red;">'. $link->connect_error .'</span><br>';
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="styleSheet" href="styleSheet.css?v=<?php echo date('his'); ?>">
		<title>PsiPi</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	</head>
	<body>
		<?php include("header.php");
		  $_SESSION['activeTool'] = 0;
			if (isset($_GET['active'])) {
				$_SESSION['activeTool'] = $_GET['active'];
			}
		?>
		<div class="sideBar">
			<?php
				for ($sectionIndex = 0; $sectionIndex < count($sections); $sectionIndex++) {
					echo '<div class="sideBarSection">';
					echo '<p>' . $sections[$sectionIndex] . '</p>';

					for ($i = 0; $i < count($toolList); $i++) {
						if ($toolList[$i]->sectionIndex == $sectionIndex) {
							echo '<a onclick="toolSelected(' . $i . ')">' . $toolList[$i]->name . '</a>';
						}
					}

					echo '</div>';
				}
			?>
		</div>
		<section>
			<h2 id="toolName"><?php echo $sections[$toolList[$_SESSION['activeTool']]->sectionIndex] . ": ". $toolList[$_SESSION['activeTool']]->name; ?></h2>
			<p id="toolDescription"><?php echo $toolList[$_SESSION['activeTool']]->description; ?></p>
			<form method="post">
				<label for="searchInput">Input:</label>
				<br>
				<input type="text" id="searchInput" name="searchInput">
				<br>
				<input type="submit" value="Search">
			</form>
			<script>
				var tags = [    <?php
						$result = $link->query($toolList[$_SESSION['activeTool']]->autoComplete);
						$row = $result->fetch_array(MYSQLI_NUM);
						if ($row) {
							echo '"' . $row[0] . '"';
						}
						while($row = $result->fetch_array(MYSQLI_NUM)) {
							echo ',"' . $row[0] . '"';
						}
						?>
					   ]
				$("#searchInput").autocomplete({
					source: function( request, response ) {
						var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
						response( $.grep( tags, function( item ){
							return matcher.test( item );
						}) );
					}
				});
			</script>
			<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					$_SESSION['input'] = $_POST['searchInput'];
					$_SESSION['query'] = $toolList[$_SESSION['activeTool']]->query;
					header('Location: http://clabsql.clamv.jacobs-university.de/~pthapa/searchResultPage.php');
				}
			?>
		</section>
		<script>
			var activeTool = 0;

			function toolSelected (toolIndex) {
				activeTool = toolIndex;
				window.location.replace("http://clabsql.clamv.jacobs-university.de/~pthapa/mainPage.php?active=" + activeTool);
			}

		</script>
	</body>
</html>
