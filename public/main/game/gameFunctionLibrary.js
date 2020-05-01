// Dev tool to save time
function getID(id)
{
	return document.getElementById(id);
}

/* 
	First function that is being called when the game starts.
	It will reset score, lives, enemy positions, etc to its default state.
	This is also called when restart button is pressed.
 */ 
function start()
{
	// Stop enemies from moving
	for (var i = 0; i < enemyMovementIntervals.length; i++)
	{
		clearInterval(enemyMovementIntervals[i]);
	}

	// Stop the enemy spawn
	for (var i = 0; i < enemiesSpawnDelays.length; i++)
	{
		clearTimeout(enemiesSpawnDelays[i]);
	}

	// Destory any enemy on screen
	for (var i = 0; i < enemies.length; i++)
	{
		enemies[i].remove(); 
	}

	// Reset variables to initial state
	lives = initialLives;
	score = 0;

	// Update the dom with the default values
	getID('lives').innerHTML = lives;
	getID('score').innerHTML = score;

	enemies = [];
	enemiesSpawnDelays = [];
	enemyMovementIntervals = [];

	// We do this for each enemy, so we need to know the maximum amount of enemies that will be spawned  
	for (var i = 0; i < maxEnemies; i++)
	{
		// This way, we'll make them spawn in succession
		var spawnDelay = delayBetweenSpawns * i; 
	
		// We add an interval in between each spawn (so we dont spawn them all at the same time)
		// https://www.w3schools.com/jsref/met_win_settimeout.asp
		var spawningTimeout = setTimeout(createFallingEnemy, spawnDelay);
		enemiesSpawnDelays.push(spawningTimeout);
	}
}

// Function to create the enemies
function createEnemy()
{
	changeSkin();
	// We create a div element that will act as the enemy
	var enemy = document.createElement('div');
	enemy.className = 'enemy';

	// https://developer.mozilla.org/en-US/docs/Web/API/Element/mousedown_event
	enemy.addEventListener('mousedown', function ()
	{
		enemyClick(enemy);
	});

	// https://developer.mozilla.org/en-US/docs/Web/API/Element/contextmenu_event
	enemy.addEventListener('contextmenu', function (e)
	{
		// Prevents right clicking the enemy
		e.preventDefault(); 
	});

	// https://developer.mozilla.org/en-US/docs/Web/API/HTML_Drag_and_Drop_API
	enemy.addEventListener('dragstart', function (e)
	{
		// Prevents dragging an enemy
		e.preventDefault(); 
	});

	// We add said div element inside the div for the boundaries of the game
	limitBounds.appendChild(enemy);
	enemies.push(enemy);

	enemyResetPosition(enemy);

	// We return the enemy "object"
	return enemy;
}

// Function make the enemies fall
function createFallingEnemy()
{
	// Create an enemy "object"
	var enemy = createEnemy();

	// Add "gravity" in intervals for the enemy to be falling down
	var movingInterval = setInterval(enemyTouchBottom, timeStep, enemy);
	enemyMovementIntervals.push(movingInterval);
}

// Function in charge of the behaviour of the enemy every time we click on them
function enemyClick(enemy)
{
	// We dont add score once the game is over (lives are <= 0)
	if (lives <= 0)
		return;

	// Once the enemy is clicked, we add 1 point to the score
	score++;
	// Then we update the score in the document in real time
	getID('score').innerHTML = score;

	// We "kill" the enemy, resetting it's position to a random position on the top 
	enemyResetPosition(enemy);
}

// Function to reset the position of the enemy to a random X position
function enemyResetPosition(enemy)
{
	// We reset the position of the enemy 
	resetPosition(enemy);

	//  Function to reset the position of the enemy, it takes an "enemy object" as parameter
	function resetPosition(enemy)
	{
		enemy.style.left = getRandomLeftPos(enemy) + 'px';
		enemy.style.top = '0px';
	}

	// We generate a random X value for the position of the enemy
	function getRandomLeftPos(enemy)
	{
		// Subtract enemy's width so they dont spawn outside the boundaries of the game
		var widthAllowedSpawning = (limitBounds.clientWidth - enemy.offsetWidth);

		return Math.round(widthAllowedSpawning * Math.random());
	}

}

// Function in charge of moving the enemies to the bottom border, substract our lives, 
// reset their position to the top if they didnt die and game over function call
function enemyTouchBottom(enemy)
{
	// We get the boundaries of our bottom border for the enemies to "die" or kill us.
	var touchBottom = (enemy.offsetTop + enemy.offsetHeight >= limitBounds.clientHeight);

	// If the enemy hasn't reached the bottom border
	if (!touchBottom)
	{
		// We move it by the speed in pixels on our game variables.
		enemy.style.top = parseInt(enemy.style.top) + moveStep + 'px';
		return;
	}

	// If the enemy has touched the bottom border of the boundaries, substract a life
	lives--;
	// And then we update the document data for lives. 
	getID('lives').innerHTML = lives;

	// If the game is not over, we have to reset the position of the enemy (so it does not keep falling below the bottom border of the game)
	if (lives > 0)
	{
		enemyResetPosition(enemy);
		return;
	}

	// If the game is over, its game over and we color the last enemy in red
	enemy.style.backgroundColor = 'red'; 
	gameOver();
}


// Function for the game over behaviour, it will stop anything from moving and being interactuable (cannot click boxes)
function gameOver()
{
	// Retrieve the score and the user from the document
	var gameOverScore = getID("score").innerHTML;
	var gameOverUser = getID("user").innerHTML;

	// Here we store the api's url
	var url = `api.php?username=${gameOverUser}&score=${gameOverScore}&action=getPoints`;

		// We make use of our api to make the SQL queries to update our score.
		useAPI(url, function (data)
		{
			getID('points').innerHTML = data;
		});

	// Stop moving the enemies
	for (var i = 0; i < enemyMovementIntervals.length; i++)
	{
		clearInterval(enemyMovementIntervals[i]);
	}

	// We stop spawning enemies
	for (var i = 0; i < enemiesSpawnDelays.length; i++)
	{
		clearTimeout(enemiesSpawnDelays[i]);
	}
	
}

// Function that calls the api to check the user's skin
function changeSkin()
{
	// Retrieve the user from the document
	var gameOverUser = getID("user").innerHTML;

	// Here we store the api's url
	var url = `api.php?username=${gameOverUser}&action=checkSkin`;

		// We make use of our api to make the SQL queries to update our score.
		useAPI(url, function (data)
		{
			enemy.style.backgroundImage = data;
		});
}

// Api call to update our database's score
// https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest
function useAPI(url, callback)
{
    var htttpRequest = new XMLHttpRequest();
    htttpRequest.open('GET', url);
    htttpRequest.send();

    htttpRequest.onreadystatechange = function ()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            callback(htttpRequest.responseText);
        }
    }
}