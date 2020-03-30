<?php
	session_start();
	include("public/main/private/functionLibrary.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
 	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Index</title>	
	
	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="assets/styles.css" media="all" rel="stylesheet" type="text/css"/>	

	
</head>
	<body>
		<div class="container wrapper">
			<?php
				include("public/main/controller.php");
			?>
		</div>
	</body>
</html>