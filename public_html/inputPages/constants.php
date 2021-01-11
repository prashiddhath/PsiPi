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
			<h2>Constants:</h2>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" autocomplete="off">
				Name: <input type="text" name="name" maxlength="50" required>
				<br>
				Unit: <input type="text" name="unit" maxlength="50">
				<br>
				Symbol: <input type="text" name="symbol" maxlength="10" required>
				<br>
				Value: <input type="number" name="value" step="any" required>
				<br>
				Exponent: <input type="number" name="exponent" required>
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
				<input type="submit" value="Add Tuple">
			</form>
			<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST") {

					$name = mysqli_real_escape_string($link,$_POST['name']);
					$unit = mysqli_real_escape_string($link,$_POST['unit']);
					$symbol = mysqli_real_escape_string($link,$_POST['symbol']);
					$value = mysqli_real_escape_string($link,(string)$_POST['value']);
					$exponent = mysqli_real_escape_string($link,(string)$_POST['exponent']);
					$creator = mysqli_real_escape_string($link,$_POST['creator']);
					$_SESSION['flag'] = 0;

					if (strlen($unit) == 0) {
						$unit = "NULL";
					}

					$id = 0;
					while (($link->query("SELECT * FROM Quantities WHERE qid='$id'"))->num_rows > 0) {
						$id++;
					}

					if (($link->query("SELECT * FROM Quantities WHERE name='$name'"))->num_rows == 0) {
						$sql1 = "INSERT INTO Quantities (qid, name, unit) VALUES ($id, '$name', '$unit')";
						$sql2 = "INSERT INTO Variables (vid, symbol) VALUES ($id, '$symbol')";
						$sql3 = "INSERT INTO Constants (cid, value, exponent, creator) VALUES ($id, $value, $exponent, $creator)";
						if(!$link->query($sql1) || !$link->query($sql2) || !$link->query($sql3)) {
							header('Location: http://clabsql.clamv.jacobs-university.de/~pthapa/feedbackPage.php');
							$_SESSION['flag'] = 1;
							$_SESSION['msg'] = 'Failed to insert ' . $name . ': ' . $link->error;
						} else {
							header('Location: http://clabsql.clamv.jacobs-university.de/~pthapa/feedbackPage.php');
							$_SESSION['msg'] = $name . ' inserted into the database.';
						}
					} else {
						header('Location: http://clabsql.clamv.jacobs-university.de/~pthapa/feedbackPage.php');
						$_SESSION['flag'] = 1;
						$_SESSION['msg'] = 'Failed to insert: name must be unique.';
					}
				}
			?>

		</section>
	</body>
</html>
