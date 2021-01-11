<html>
	<head>
		<link rel="styleSheet" href="styleSheet.css?v=<?php echo date('his');?>">
		<title>Feedback Page</title>
	</head>
	<body>
		<section>
			<a href="http://clabsql.clamv.jacobs-university.de/~pthapa/maintenancePage.php">Back to Maintenance Page</a></section>
			<?php
				include("header.php");
				session_start();
				if ($_SESSION['flag'] == 1 && isset($_SESSION['msg'])) {
					echo '<span style = "color:red;">' . $_SESSION['msg'] . '</span>';
				}
				if ($_SESSION['flag'] == 0 && isset($_SESSION['msg'])) {
					echo '<span style = "color:green;">' . $_SESSION['msg'] . '</span>';
				}
			?>
		</section>
	</body>
</html>
