<?php
	session_start();
	if(isset($_SESSION['logged_in'])) {
		header('Location: http://clabsql.clamv.jacobs-university.de/~jwhiteley/maintenancePage.php');
	}

	$link = new mysqli('localhost','group9','xNs1UQ', 'group9');
	if($link->connect_error) {
		echo '<span style="color:red;">Could not connect to database server:</span><br>';
		echo '<span style="color:red;">'. $link->connect_error .'</span><br>';
	}

?>

<html>
	<head>
		<link rel="styleSheet" href="styleSheet.css?v=<?php echo date('his');?>">
		<title>Authentication</title>
	</head>
	<body>
		<?php include("header.php"); ?>
		<section>
			<h2>Enter Login Details:</h2>
            <form method="post" autocomplete="off">
				<label for="searchInput">Username:</label>

					<input type="text" id="username" name="username" autocomplete="off">
                <br>
                <label for="searchInput">Password:</label>
                    <input type="password" id="password" name="password" autocomplete="off">
                <br>
				    <input type="submit" value="Login">
			</form>
			<?php
			if(count($_POST)>0) {
				$query = "SELECT * FROM Authorization WHERE username= ? and password = ?;";
				$username = $_POST["username"];
				$userpass = $_POST["password"];
				$smt = mysqli_stmt_init($link);
				if (!mysqli_stmt_prepare($smt, $query)) {
					echo '<span style = "color:red;">' . $link->error . '</span>';
				} else {
					//table first row (labels)
					mysqli_stmt_bind_param($smt, "ss", $username, $userpass);
					mysqli_stmt_execute($smt);
					$result = mysqli_stmt_get_result($smt);
					$count  = mysqli_num_rows($result);
					if($count==0) {
						echo '<span style="color:red;">Invalid username and/or password</span><br>';
					} else {
						$_SESSION['logged_in'] = $_POST["username"];
						header('Location: http://clabsql.clamv.jacobs-university.de/~jwhiteley/maintenancePage.php');
					}
				}
			}
			?>
		</section>
	</body>
</html>
