<?php
	session_start();
	include_once("public/main/private/functionLibrary.php");
	include_once("public/main/private/db_con.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Index</title>
	<link href="assets/styles.css" media="all" rel="stylesheet" type="text/css"/>	
</head>
	<body>
			<?php
				include("public/main/controller.php");
			?>
	</body>
</html>