<?php
	$link = new mysqli('localhost','group9','xNs1UQ', 'group9');
	if($link->connect_error) {
		echo '<span style="color:red;">Could not connect to database server:</span><br>';
		echo '<span style="color:red;">'. $link->connect_error .'</span><br>';
	}
	if (!session_id()) {
		session_start();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="styleSheet" href="../styleSheet.css?v=<?php echo date('his'); ?>">
		<title>PsiPi</title>
	</head>
	<body>
		<?php include("../header.php"); ?>
		<section>
			<h2>Quantities:</h2>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" autocomplete="off">
				Name: <input type="text" name="name" maxlength="50" required>
				<br>
				Unit: <input type="text" name="unit" maxlength="50">
				<br>
				<input type="submit" value="Add Tuple">
			</form>

			<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST") {

					$name = mysqli_real_escape_string($_POST['name']);
					$unit = mysqli_real_escape_string($_POST['unit']);
					$_SESSION['flag'] = 0;

					if (strlen($unit) == 0) {
						$unit = "NULL";
					}

					$id = 0;
					while (($link->query("SELECT * FROM Quantities WHERE qid='$id'"))->num_rows > 0) {
						$id++;
					}

					if (($link->query("SELECT * FROM Quantities WHERE name='$name'"))->num_rows == 0) {
						$sql = "INSERT INTO Quantities (qid, name, unit) VALUES ($id, '$name', '$unit')";
						if(!$link->query($sql)) {
							header('Location: http://clabsql.clamv.jacobs-university.de/~pthapa/feedbackPage.php');
							$_SESSION['flag'] = 1;
							$_SESSION['msg'] = 'Failed to insert ' . $name . ': ' . $link->error;
						} else {
							header('Location: http://clabsql.clamv.jacobs-university.de/~pthapa/feedbackPage.php');
							$_SESSION['msg'] = $name . ' inserted into the database';
						}
					} else {
						header('Location: http://clabsql.clamv.jacobs-university.de/~pthapa/feedbackPage.php');
						$_SESSION['flag'] = 1;
						$_SESSION['msg'] = 'Failed to insert ' . $name. ': name must be unique';
					}
				}
			?>

		</section>
	</body>
</html>
