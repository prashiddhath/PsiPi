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
			<h2>Part Of:</h2>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" autocomplete="off">
				Variable: <select name="vid" id="vid" required>
						<?php
							$result = $link->query("SELECT qid, name FROM Quantities INNER JOIN Variables ON qid = vid");
							while ($tuple = $result->fetch_assoc()) {
								echo '<option value="' . $tuple["qid"] . '">' . $tuple["name"] . '</option>';
							}
						?>
					</select>
				<br>
				Equation: <select name="eqid" id="eqid" required>
						<?php
							$result = $link->query("SELECT eqid, name FROM Equations");
							while ($tuple = $result->fetch_assoc()) {
								echo '<option value="' . $tuple["eqid"] . '">' . $tuple["name"] . '</option>';
							}
						?>
					</select>
				<br>
				<input type="submit" value="Add Tuple">
			</form>

			<?php
				if ($_SERVER["REQUEST_METHOD"] == "POST") {

					$vid = mysqli_real_escape_string($link,(string)$_POST['vid']);
					$eqid = mysqli_real_escape_string($link,(string)$_POST['eqid']);
					$_SESSION['flag'] = 0;

					if (($link->query("SELECT * FROM Part_of WHERE vid=$vid AND eqid=$eqid"))->num_rows == 0) {
						$sql = "INSERT INTO Part_of (vid, eqid) VALUES ($vid, $eqid)";
						if(!$link->query($sql)) {
							header('Location: http://clabsql.clamv.jacobs-university.de/~pthapa/feedbackPage.php');
							$_SESSION['msg'] = 'Failed to insert:' . $link->error;
							$_SESSION['flag'] = 1;
						} else {
							header('Location: http://clabsql.clamv.jacobs-university.de/~pthapa/feedbackPage.php');
							$_SESSION['msg'] = 'Data inserted into the database.';
						}
					} else {
						header('Location: http://clabsql.clamv.jacobs-university.de/~pthapa/feedbackPage.php');
						$_SESSION['msg'] = 'Failed to insert: relation already exists.';
						$_SESSION['flag'] = 1;
					}
				}
			?>

		</section>
	</body>
</html>
