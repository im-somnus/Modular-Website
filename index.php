<?php
	session_start();
	include("public/main/private/functionLibrary.php");
	
	if (isset($_SESSION['login']))
	{
		keepOnlineStatus($_SESSION['login']['user']);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="description" content="Webpage designed for my game project"></meta>
	<meta name="author" content="Edgar Álvarez González">
	<meta charset="utf-8">
	<meta name="theme-color" content="rgb(83, 82, 82);"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="apple-touch-icon" href="assets/images/others/icon.png">

	<title>Index</title>	

	<!-- BOOTSTRAP -->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" rel="import"	></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" rel="import"></script>
	<link href="assets/styles.css" media="all" rel="stylesheet" type="text/css"/>	
	
	<script src="public/main/game/gameFunctionLibrary.js"></script>

</head>
	<body>
		<div class="container-fluid">
			<?php
				// Include the controller in charge of displaying the content
				include("public/main/controller.php");
			?>
		</div>

		<script src="public/main/game/gameInitialization.js"></script>

	</body>
</html>