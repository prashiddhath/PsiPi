<?php
	$link = new mysqli('localhost','group9','xNs1UQ', 'group9');
	if($link->connect_error) {
		echo '<span style="color:red;">Could not connect to database server:</span><br>';
		echo '<span style="color:red;">'. $link->connect_error .'</span><br>';
	}
?>
<html>
	<head>
		<link rel="styleSheet" href="styleSheet.css?v=<?php echo date('his');?>">
		<title>PsiPi</title>
	</head>
	<body>
		<?php include("header.php"); ?>
		<section>
			<?php
				if (!session_id()) {
					session_start();
				}
				$fetchrow = $_GET['r'];
				$input = $_SESSION['input'];
				$query = $_SESSION['query'];
				$smt = mysqli_stmt_init($link);

				if (!mysqli_stmt_prepare($smt, $query)) {
					echo '<span style = "color:red;">' . $link->error . '</span>';
				} else {
					//table first row (labels)
					mysqli_stmt_bind_param($smt, "s", $input);
					mysqli_stmt_execute($smt);
					$result = mysqli_stmt_get_result($smt);
					if ($result->num_rows == 0) {
						echo '<span style = "color:red;">Nothing found that matches your search.</span>';
					}
					else {
					//table first row (labels)
					echo '<table><tr>';
					while ($field = $result->fetch_field()) {
						echo '<th>' . $field->name . '</th>';
					}
					$nrow = 0;
					//table remaining rows (data)
					while($row = $result->fetch_assoc()) {
						$nrow = $nrow + 1;
						if ($nrow == $fetchrow) {
							echo '<tr>';
							foreach ($row as $element) {
								echo '<td>' . $element . '</td>';
							}
						}
					}
					echo '</table>';
				}
			}
			?>
			<a href="http://clabsql.clamv.jacobs-university.de/~jwhiteley/searchResultPage.php">Back to Result Page</a>
		</section>
	</body>
</html>
