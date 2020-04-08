<?php
    session_start();
    require("admFunctionLibrary.php");
    require("../functionLibrary.php");
    admRankCheck(1);
    
	if (isset($_SESSION['login']))
	{
		keepOnlineStatus($_SESSION['login']['user']);
	}
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
	<link href="admstyles.css" media="all" rel="stylesheet" type="text/css"/>	
</head>
	<body>
		<div class="container">
            <div class="windowAlert">
				<?php
						include("../alertMessageModule.php");
				?>
			</div>
			<div class="windowMain">
				<?php
				 	removePosts();
				?>
			</div>
		</div>
	</body>
</html>