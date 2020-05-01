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

  // Function to check the user's skin
  function checkSkin($username)
  {
      require("public/main/private/db_con.php");
      require("public/main/private/functionLibrary.php");
      $sql = "SELECT skin FROM accounts where username='$username';";
      
      if(executeQuery($sql))
      {
          $result = mysqli_query($link, $sql);
          $resultCheck = mysqli_num_rows($result);

            // We will keep iterating as long as theres data
            if ($resultCheck > 0)
            {
              while ($row = mysqli_fetch_assoc($result))
              {
                  $skin = $row['skin'];
                  $skin = checkItemImage($skin);
                  return $skin; 

              }
            }
      }
      else
      {
          echo "Couldnt find any skin, try again.";
          exit();
      }
  }


  // Function that checks the shop skin name
  function checkItemImage($skin)
  {
      require("public/main/private/db_con.php");
      $sql = "SELECT itemImage FROM shop where itemID='$skin';";
      
      if(executeQuery($sql))
      {
          $result = mysqli_query($link, $sql);
          $resultCheck = mysqli_num_rows($result);

            // We will keep iterating as long as theres data
            if ($resultCheck > 0)
            {
              while ($row = mysqli_fetch_assoc($result))
              {
                  $image = $row['itemImage'];  
                  return $image;   
              }
            }
      }
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