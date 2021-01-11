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
			<h2>Polynomial Equations:</h2>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" autocomplete="off">
				Name: <input type="text" name="name" maxlength="50" required>
				<br>
				Latex Code: <input type="text" name="latexCode" maxlength="256" required>
				<br>
				Field: <select name="field" id="field">
						<option value="NULL" selected>Unknown</option>
						<?php
							$result = $link->query("SELECT name FROM Fields");
							while ($tuple = $result->fetch_assoc()) {
								echo '<option value="\'' . $tuple["name"] . '\'">' . $tuple["name"] . '</option>';
							}
						?>
					</select>
				<br>
				Creator: <select name="creator" id="creator">
						<option value="NULL" selected>Unknown</option>
						<?php
							$result = $link->query("SELECT name FROM Physicists");
							while ($tuple = $result->fetch_assoc()) {
								echo '<option value="\'' . $tuple["name"] . '\'">' . $tuple["name"] . '</option>';
							}
						?>
					</select>
				<br>
				Equation Degree: <input type="number" name="eqDegree" required>
				<br>
				<input type="submit" value="Add Tuple">
			</form>

			<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST") {

					$name = mysqli_real_escape_string($link,$_POST['name']);
					$latexCode = mysqli_real_escape_string($link,$_POST['latexCode']);
					$field = mysqli_real_escape_string($link,$_POST['field']);
					$creator = mysqli_real_escape_string($link,$_POST['creator']);
					$eqDegree = mysqli_real_escape_string($link,$_POST['eqDegree']);
					$_SESSION['flag'] = 0;

					$id = 0;
					while (($link->query("SELECT * FROM Equations WHERE eqid='$id'"))->num_rows > 0) {
						$id++;
					}

					if (($link->query("SELECT * FROM Equations WHERE name='$name'"))->num_rows == 0) {
						if (($link->query("SELECT * FROM Equations WHERE latexCode='$latexCode'"))->num_rows == 0) {
							$sql1 = "INSERT INTO Equations (eqid, name, latexCode, field, creator) VALUES ($id, '$name', '$latexCode', $field, $creator)";
							$sql2 = "INSERT INTO Polynomial_equations (peid, eqDegree) VALUES ($id, $eqDegree)";
							if(!$link->query($sql1) || !$link->query($sql2)) {
								header('Location: http://clabsql.clamv.jacobs-university.de/~pthapa/feedbackPage.php');
								$_SESSION['msg'] = 'Failed to insert:' . $link->error;
								$_SESSION['flag'] = 1;
							} else {
								header('Location: http://clabsql.clamv.jacobs-university.de/~pthapa/feedbackPage.php');
								$_SESSION['msg'] = $name . ' inserted into the database.';
							}
						} else {
							header('Location: http://clabsql.clamv.jacobs-university.de/~pthapa/feedbackPage.php');
							$_SESSION['msg'] = 'Failed to insert: latex code must be unique.';
							$_SESSION['flag'] = 1;
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
