/* 
###############################  GAME variables   ################################
*/

// Max number of enemies that can be spawned
var maxEnemies = 4; 

// Delay between enemy spawn in miliseconds
var delayBetweenSpawns = 1800; 

// Fall movement of the enemies in pixels
var moveStep = 1; 
// Time of falling in miliseconds
var timeStep = 10; 

// Initial amount of lifes
var initialLives = 3; 
var lives = initialLives;

// Initial score/points
var score = 0;

// Generating enemies and bounds variables
var enemies = [];
var enemiesSpawnDelays = [];
var enemyMovementIntervals = [];
var limitBounds = getID('limitBounds');



/* 
###############################  Event Listeners   ################################
*/

// https://developer.mozilla.org/en-US/docs/Web/API/Element/contextmenu_event
limitBounds.addEventListener('contextmenu', function (e)
{
	// Prevents right clicking in the game box
	e.preventDefault(); 
});

// https://developer.mozilla.org/en-US/docs/Web/API/HTML_Drag_and_Drop_API
limitBounds.addEventListener('dragstart', function (e)
{
	// Removes "dragging an item" in the game box
	e.preventDefault(); 
});

// https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/addEventListener
getID('restart').addEventListener('click', function ()
{
	// Start game function if restart button is clicked
	start();
});

/* 
###############################  Game entry point/main   ################################
*/

start();