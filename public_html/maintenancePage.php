<?php
	session_start();
	if(! isset($_SESSION['logged_in'])) {
		header("Location: http://clabsql.clamv.jacobs-university.de/~pthapa/Login.php");
	}
?>

<html>
	<head>
		<link rel="styleSheet" href="styleSheet.css?v=<?php echo date('his');?>">
		<title>Maintenance Page</title>
	</head>
	<body>
		<?php include("header.php"); ?>
		<section>
			<h2>Input Pages:</h2>
			<?php
				$dir = 'inputPages';
				$handle = opendir($dir);

				if($handle){
					while(($entry = readdir($handle)) !== false){
						if(is_file($dir.DIRECTORY_SEPARATOR.$entry)){
							$name = substr($entry, 0, strpos($entry, "."));
							if(!$name) {
								$name = "err: failed while calling substr on name";
							}
							echo "<a href=$dir/$entry>$name</a><br>";
						}
					}
					closedir($handle);
				} else {
					echo "<p style=\"color:red\">err: failed to open directory: $dir</p>";
				}
			?>
		</section>
	</body>
</html>
