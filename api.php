<?php
/* 
  Website api to update score/points in our DB from our game
  This api is only called from the game, but with the "access control allow origin" can be called outside our domain
*/

  header("Access-Control-Allow-Origin: *");

  // Function to get the user points from our database
  function getUserPoints($username, $score)
  {
    require("public/main/private/functionLibrary.php");
    $points = returnPoints($username);
    increasePointsUser($username, $score, $points);
  }

  // Function to increase the points of the user from our database
  function increasePointsUser($username, $score, $points)
  {
      require("public/main/private/db_con.php");
      $points = $points + $score;
      $sql = "UPDATE accounts SET points='$points' where username='$username';";
      mysqli_query($link, $sql);
      mysqli_close($link);

      // output our points
      echo $points;
  }

  // Retrieve the data from the URL
  $username = $_GET['username'] ?? false;
  $score = $_GET['score'] ?? false;
  $action = $_GET['action'] ?? false;
  
  // If no user was given, we output an error
  if ($username === false)
  {
    echo 'missing username';
    exit;
  }

  // If no action was given, we output an error
  if ($action === false)
  {
    echo 'missing action';
    exit;
  }

  // If the action was "getPoints" call the function
  if ($action === 'getPoints')
  {
    echo getUserPoints($username, $score);
    exit;
  }

  // If the action was "checkSkin" call the function
  if ($action === 'checkSkin')
  {
    echo checkSkin($username);
    exit;
  }

?>