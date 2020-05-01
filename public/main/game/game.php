<?php
	if (isset($_SESSION['login']))
	{
		keepOnlineStatus($_SESSION['login']['user']);
	}
?>

<!-- GUI for the score and buttons -->
<div class="gui">
	Score: <span id='score'>0</span><br>
	Lives: <span id='lives'>0</span>
	<!-- Reset button  -->
	<div class="reset">
		<input type='button' id='restart' value='RESET'>
	</div>
</div>


<!-- Area for the game to play -->
<div id='limitBounds'></div>

