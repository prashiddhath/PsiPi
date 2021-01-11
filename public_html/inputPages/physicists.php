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
			<h2>Physicists:</h2>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" autocomplete="off">
				Name: <input type="text" name="name" maxlength="50" required>
				<br>
				Nationality: <input type="text" name="nationality" maxlength="50">
				<br>
				Birth Year: <input type="number" name="birthYear">
				<br>
				Death Year: <input type="number" name="deathYear">
				<br>
				<input type="submit" value="Add Tuple">
			</form>
			<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST") {

					$name = mysqli_real_escape_string($link,$_POST['name']);
					$nationality = mysqli_real_escape_string($link,$_POST['nationality']);
					$birthYear = mysqli_real_escape_string($link,(string)$_POST['birthYear']);
					$deathYear = mysqli_real_escape_string($link,(string)$_POST['deathYear']);
					$_SESSION['flag'] = 0;

					if (strlen($nationality) == 0) {
						$nationality = "NULL";
					}
					if (strlen($birthYear) == 0) {
						$birthYear = "NULL";
					}
					if (strlen($deathYear) == 0) {
						$deathYear = "NULL";
					}

					if (($link->query("SELECT * FROM Physicists WHERE name='$name'"))->num_rows == 0) {
						$sql = "INSERT INTO Physicists (name, nationality, birthYear, deathYear) VALUES ('$name', '$nationality', $birthYear, $deathYear)";
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
						$_SESSION['msg'] = 'Failed to insert: name must be unique.';
						$_SESSION['flag'] = 1;
					}
				}
			?>
		</section>
	</body>
</html>
