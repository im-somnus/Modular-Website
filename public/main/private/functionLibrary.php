<?php

/* 
    Biggest file in the project. Contains all the functionallity of the website.
    This file will be called by other files in the server, providing them with functionallity.
    
    There's also testing tools for developers, and other helpful functions to make it easier
        for the devs to work and maintain the site.
*/

/* ####################################### TESTING TOOLS ####################################### */

// function to dump all variables (test)
function dump($v)
{
    echo "<pre>";
        var_dump($v);
    echo "<pre>";
}



/* ####################################### GENERIC FUNCTIONS ####################################### */

// Check if an user has the rank to access a page (nobody but administrator rank can access admin panel for example)  
function rankCheck($rank)
{
    // If session is not set, or session is not equal to the value we passed as parameter.
    if(!isset($_SESSION["rank"]) || $_SESSION["rank"] > $rank || !isset($_SESSION['login']))
    { 
        $_SESSION['error'] = "You don't have enough permissions to access this page.";
        
        header("Location: index.php");
        exit();
    }
}

// Check if an user has the rank to access a page (nobody but administrator rank can access admin panel for example)  
function admRankCheck($rank)
{
    // If session is not set, or session is not equal to the value we passed as parameter.
    if(!isset($_SESSION["rank"]) || $_SESSION["rank"] > $rank || !isset($_SESSION['login']))
    {        
        header("Location: index.php");
        exit();
    }
}


// Validate the user input from login/register modules.
function validateUserInput($user, $pass)
{
    $pattern = "/^[A-Za-z0-9][A-Za-z0-9_-]{3,21}$/";
    // Check if username meets the minimum requirements.
    if (!preg_match($pattern, $user))
    {
        $_SESSION['error'] = "Username does not meet the requirements, try again";

        header("location: ../../../index.php");
        exit();
    }

    // Check if password meets the next pattern;
    $pattern = "/[@$%&A-Za-zçñ0-9_-]{3,20}$/";

    if (!preg_match($pattern, $pass))
    {
        $_SESSION['error'] = "Password does not meet the requirements, try again";

        header("location: ../../../index.php");
        exit();
    }
    
}


// Validate post's and thread's user input
Function validateForumInput($post)
{
    // ValidatePost
    $pattern = '/[ºª\"\'!·$%&Za-zçñ0-9_-]{1-2001}$/';

    if (!preg_match($pattern, $post))
    {
        $_SESSION['error'] = "Post couldn't be posted, try again";
        return 0;
    }
}


/* ####################################### QUERY/SQL FUNCTIONS ####################################### */

// Function to shorten the queries, sends 0 if the query failed, 1 if it worked.
function executeQuery($query)
{
    require("db_con.php");

    if ($result = mysqli_query($link, $query))
    {
        mysqli_close($link);
        // Returns true if success Query
        return 1;
    }
    else
    {
        mysqli_close($link);
        // Returns false if failed Query
        return 0;
    }
}


/* ####################################### USERS FUNCTIONS ####################################### */

// Set to 1 the user status (online)
function setOnlineStatus($user)
{
    require("db_con.php");

    $sql = "UPDATE accounts SET userStatus='1' where username='$user';";
    mysqli_query($link, $sql);

    mysqli_close($link);
}

// Function to update lastActivity timestamp in the database using $_SESSION when loading pages.
function keepOnlineStatus($user)
{
    require("db_con.php");

    // Set default timezone
    date_default_timezone_set('Europe/Madrid');
    // Store custom date format in a variable
    $date = date('Y-m-d H:i:s');

    // Update user user last activity with current time
    $sql = "UPDATE accounts SET lastActivity='$date' where username='$user';";
    mysqli_query($link, $sql);

    // Function that sets online status to "online"
    setOnlineStatus($user);
}

// Set to 0 the user status (offline).
function setOfflineStatus($user)
{
    require("db_con.php");

    // update status to 0 (offline)
    $sql = "UPDATE accounts SET userStatus='0' where username='$user';";
    mysqli_query($link, $sql);

    mysqli_close($link);
}

// Function to register an account
function register($user, $pass)
{
    require("db_con.php");

     // Validate if that user input was valid before doing any queries.
     validateUserInput($user, $pass);
     
     $sql = "INSERT INTO accounts (username, password)
                      VALUES ('$user', md5('$pass'))";

        // Verifying the query from the function executeQuery
        if (!executeQuery($sql))
        {
            // Store the error in the session variable to display in main
            $_SESSION['error'] = "ERROR! The username you entered is already in use.";

            header("location: ../../../index.php");
            exit();
        }
       

        $_SESSION['success'] = "You have successfully created your account.";

        $path = "../../../assets/images/users/profilePictures/";
        $mkdirPath = $path . $user . "/";
        if (!file_exists($mkdirPath))
        {
            mkdir($mkdirPath, 0777, true);
        }

        header("location: ../../../index.php");
        
}

// Function that verifies user login information and logs in the database.
function login($user, $pass)
{
    require("db_con.php");

    // Validate if that user input was valid before doing any queries.
    validateUserInput($user, $pass);

    // Check the data against the database
    $sql = "Select * from accounts where username='$user' and password=md5('$pass')";
    $result = mysqli_query($link, $sql);

    // Check if there are any results in the query
    $row = mysqli_fetch_assoc($result);

    // If there's a result, means login is succesful (pass and user are valid)
    if (!$row)
    {
        $_SESSION['error'] = "Login error, try again.";

        header("location: ../../../index.php");
        exit();
    }

        // Store the user and rank data in the session to use it later on
        $_SESSION['login']['user'] = $_POST['user'];
        $_SESSION['rank'] = $row["rank"];

        // We set the status online and update the online timer to keep the online session up
        setOnlineStatus($_SESSION['login']['user']);
        keepOnlineStatus($_SESSION['login']['user']);
        
        // Redirect the user to the home page, since its valid.
        header("location: ../../../index.php");
        exit();
}


// Function to logout the users, destroy all session variables etc.
function logout($user)
{
    // We set the user status from online (1) to offline (0)
    $user = $_SESSION['login']['user'];
    setOfflineStatus($user);

    // Unset the session variables.
    unset($_SESSION['login']['user']);
    unset($_SESSION['login']);
    unset($_SESSION['error']);
    unset($_SESSION['success']);
    unset($_SESSION["rank"]);
    session_destroy();

    // Redirect to the login page:
    header('Location: ../../../index.php');
    exit();
}

// Function to get the account id from thread id
function getAccountIDbyThreadID($id)
{
    require("db_con.php");
    $sql = "SELECT accounts_id FROM thread where id='$id';";
    
    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);

          // We will keep iterating as long as theres data
          if ($resultCheck > 0)
          {
            while ($row = mysqli_fetch_assoc($result))
            {
                return $row['accounts_id'];     
            }
          }
    }
}


// Function to check user's rank
function userRank($user)
{
    require("db_con.php");
    $sql = "SELECT rank FROM accounts where username='$user';";
    
    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);

          // We will keep iterating as long as theres data
          if ($resultCheck > 0)
          {
            while ($row = mysqli_fetch_assoc($result))
            {
                return $row['rank'];     
            }
          }
    }
}


/*  ####################################### USER PROFILE FUNCTIONS ####################################### */

// Checks the user's points.
function checkPoints($user)
{
    require("db_con.php");
    $sql = "SELECT points FROM accounts where username='$user';";
    
    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);

          // We will keep iterating as long as theres data
          if ($resultCheck > 0)
          {
            while ($row = mysqli_fetch_assoc($result))
            {
                return $row['points'];     
            }
          }
    }
    else
    {
        $_SESSION['error'] = "Couldn't display the value, contact an administrator.";
        exit();
    }
}

// Checks the user's points.
function returnPoints($user)
{
    require("db_con.php");
    $sql = "SELECT points FROM accounts where username='$user';";
    
    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);

          // We will keep iterating as long as theres data
          if ($resultCheck > 0)
          {
            while ($row = mysqli_fetch_assoc($result))
            {
                return $row['points'];     
            }
          }
    }
    else
    {
        $_SESSION['error'] = "Couldn't display the value, contact an administrator.";
        exit();
    }
}



// Function in charge of changing the user's profile picture
function changeImage()
{
   
    if (isset($_FILES["fileToUpload"]))
    {
        $user = $_SESSION['login']['user'];
        $path = "./assets/images/users/profilePictures/";
        $mkdirPath = $path . $user . "/";
        
        if (!file_exists($mkdirPath))
        {
            mkdir($mkdirPath, 0777);
        }

        $targetDirectory = "$mkdirPath";
        $filename = $user . "_" . $_FILES["fileToUpload"]["name"];
        $targetFile = $targetDirectory . basename($filename);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

        if (empty($_FILES["submit"]))
        {
            echo "You haven't inserted a file.";
            header("Location: index.php?profile&edit");
        }

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"]) && !empty($_FILES["fileToUpload"]))
        {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

            if ($check === false)
            {
                $uploadOk = 0;
            }
        }
        
        // Check file size for 5MB
        if ($_FILES["fileToUpload"]["size"] > 5000000)
        {
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
        {
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1)
            // Then we move the file 
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile))
            {
                require("db_con.php");
                $sql = "SELECT pfpicture FROM accounts where username='$user';";
        
                if(executeQuery($sql))
                {
                    $result = mysqli_query($link, $sql);
                    $resultCheck = mysqli_num_rows($result);
                    mysqli_close($link);
                    // We will keep iterating as long as theres data
                    if ($resultCheck > 0)
                    {
                        while ($row = mysqli_fetch_assoc($result))
                            {
                                $picture = $row['pfpicture'];

                                // We dont want to delete the default picture for all accounts, but the one the user is using
                                if ($picture != "default_pfpic.png")
                                {
                                    unlink($targetDirectory.$picture);
                                }
                            }
                    }
                }

                $sql = "UPDATE accounts SET pfpicture='$filename' where username='$user';";

                if (!executeQuery($sql))
                {
                    $_SESSION['error'] = "The image couldnt be changed, try again.";
                    header("Location: index.php?profile&edit");
                    exit();
                }

                mysqli_close($link);
                header("Location: index.php?profile");
                
            }
            else
            {
                $_SESSION['error'] = "<br>Sorry, there was an error uploading your file.";
            }
    }
}    

// Function to find the user profile picture by their username
function checkPFPByUsername($user)
{
    require("db_con.php");
    $sql = "SELECT pfpicture FROM accounts where username='$user';";
    
    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);
         mysqli_close($link);
        // We will keep iterating as long as theres data
        if ($resultCheck > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
            {
                // If the picture is the default one, we go to the main folder to retrieve it
                if ($row['pfpicture'] == "default_pfpic.png")
                {
                    echo "./assets/images/users/profilePictures/".$row['pfpicture'];
                }
                // Else we find the one in his user folder
                else
                {
                    if (file_exists("./assets/images/users/profilePictures/$user/".$row['pfpicture']))
                    {
                        echo "./assets/images/users/profilePictures/$user/".$row['pfpicture'];
                    }
                    else
                    {
                        echo "./assets/images/users/profilePictures/default_pfpic.png";
                    }
                }
            }
        }
          
    }
    else
    {
        $_SESSION['error'] = "Couldn't find the picture, contact an administrator.";
    }
}

// Returns the number of posts of an user using the username as parameter
function countPostsByUsername($user)
{
    require("db_con.php");
    $sql = "Select id from accounts where username='$user';";
    $result = mysqli_query($link, $sql);
    $resultCheck = mysqli_num_rows($result);
    mysqli_close($link);

    // We will keep iterating as long as theres data
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
            {
                // Shows the number of posts of the user
                $id = $row['id'];
                return countPostsByID($id);

            }
    }
}


function countPostsByID($id)
{
      require("db_con.php");
      // Shows the number of posts of the user
      $sql = "Select count(*) from post where accounts_id='$id';";
      $result2 = mysqli_query($link, $sql);

      $resultCheck2 = mysqli_num_rows($result2);

      // We will keep iterating as long as theres data
      if ($resultCheck2 > 0)
      {
          while ($row = mysqli_fetch_assoc($result2))
              {
                      return $row['count(*)'];            
              }
      }
      mysqli_close($link);
}

// Function to count the users that are currently online
function countOnlineUsers()
{
    require("db_con.php");
    $sql = "SELECT count(username) FROM accounts where userStatus='1';";  

    $result = mysqli_query($link, $sql);

    mysqli_close($link);
    $resultCheck = mysqli_num_rows($result);
    // We will keep iterating as long as theres data
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
           return $row['count(username)'];
        }
    }
}

// Function to show the users that are currently online
function displayOnlineUsers()
{
    require("db_con.php");
    $sql = "SELECT username, rank FROM accounts where userStatus='1';";  

    $result = mysqli_query($link, $sql);
    mysqli_close($link);

    echo "<div id='onlinePanel'>";
        echo "<h2>Who's online?</h2>";
        echo "<hr>";
        echo "Total number of users online: " . countOnlineUsers() . "<br><br> <b>Users:</b><br><br> ";

        $resultCheck = mysqli_num_rows($result);
        $counter = 0;

        // We will keep iterating as long as theres data
        if ($resultCheck >= 0)
        {
            while ($row = mysqli_fetch_array($result))
            {
                $rank = $row['rank'];

                if (++$counter == $resultCheck)
                {
                    if ($rank == 2)
                    {
                        echo $row['username'];
                    }
                    elseif ($rank == 1)
                    {
                        echo "<font color='green';>" . $row['username'] . "</font>";
                    }
                    elseif ($rank == 0)
                    {
                        echo "<font color='red';>" . $row['username'] . "</font>";
                    }
                }
                else
                {
                    if ($rank == 2)
                    {
                        echo $row['username'] . ", ";
                    }
                    elseif ($rank == 1)
                    {
                        echo "<font color='green';>" . $row['username'] . "</font>, ";
                    }
                    elseif ($rank == 0)
                    {
                        echo "<font color='red';>" . $row['username'] . "</font>, ";
                    }
                }
            }
        }
   
    echo "<br><br>";
    echo "Legend: <font color='red';> Administrator</font>, <font color='green';> Moderator</font>, User";
    echo "</div>";
}

// Returns username ID using as parameter the username.
function getAccount_IDbyUsername($username)
{
    require("db_con.php");
    $sql = "select id from accounts where username='$username';";
    
    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);
         mysqli_close($link);
          // We will keep iterating as long as theres data
          if ($resultCheck > 0)
          {
                while ($row = mysqli_fetch_assoc($result))
                {
                    return $row['id'];
                }
            
          }
    }	
}


// Echoes username username using as parameter the ID.
function usernameSelect($id)
{
    require("db_con.php");
    $sql = "SELECT username FROM accounts where id='$id';";  

    $result = mysqli_query($link, $sql);

    mysqli_close($link);

    $resultCheck = mysqli_num_rows($result);
    // We will keep iterating as long as theres data
    if ($resultCheck >= 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
             echo $row['username'];
        }
    }
}

// Returns username username using as parameter the ID.
function returnUsernameSelect($id)
{
    require("db_con.php");
    $sql = "SELECT username FROM accounts where id='$id';";  

    $result = mysqli_query($link, $sql);

    mysqli_close($link);

    $resultCheck = mysqli_num_rows($result);
    // We will keep iterating as long as theres data
    if ($resultCheck >= 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
             return $row['username'];
        }
    }
}

// Returns username username using as parameter the ID.
function adminUsernameSelect($id)
{
    require("db_con.php");
    $sql = "SELECT username FROM accounts where id='$id' and rank='0';";  

    $result = mysqli_query($link, $sql);

    mysqli_close($link);

    $resultCheck = mysqli_num_rows($result);
    // We will keep iterating as long as theres data
    if ($resultCheck >= 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
             echo "<font color='red'>" . $row['username'] ."</font>";
        }
    }
}




// Checks the user's profile picture
function checkPFPById($id)
{
      
    require("db_con.php");
    $sql = "SELECT pfpicture FROM accounts where id='$id';";
    
    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);
         mysqli_close($link);
          // We will keep iterating as long as theres data
          if ($resultCheck > 0)
          {
                while ($row = mysqli_fetch_assoc($result))
                {
                    $username = returnUsernameSelect($id);
                    // If the picture is the default one, we go to the main folder to retrieve it
                    if ($row['pfpicture'] == "default_pfpic.png")
                    {
                        echo "./assets/images/users/profilePictures/".$row['pfpicture'];
                    }
                    // Else we find the one in his user folder
                    else
                    {
                        if (file_exists("./assets/images/users/profilePictures/$username/".$row['pfpicture']))
                        {
                            echo "./assets/images/users/profilePictures/$username/".$row['pfpicture'];
                        }
                        else
                        {
                            echo "./assets/images/users/profilePictures/default_pfpic.png";
                        }
                    }
                }
          }
    }
    else
    {
        echo "Couldn't find the picture, contact an administrator.";
    }
}


// Function tho show the admin panel
function adminPanel($user, $userRank) 
{
    include("db_con.php");
    $sql = "select * from accounts where rank='$userRank' and username='$user';";  

    $result = mysqli_query($link, $sql);

    mysqli_close($link);
   
    $data = mysqli_fetch_assoc($result);
    if ($data['rank'] <= 1)
    {
           

            if ($data['rank'] == 0)
            {
                echo '<a href="index.php?admPan">Admin Panel</a>';
            }
            if ($data['rank'] == 1)
            {
                echo '<a href="index.php?admPan">Mod Panel</a>';
            }
    } 
}


// Function to show user's status
function displayUserStatus($id)
{
    require("db_con.php");
    $sql = "SELECT userStatus FROM accounts where id='$id'";  

    $result = mysqli_query($link, $sql);
    mysqli_close($link);
    $resultCheck = mysqli_num_rows($result);
    // We will keep iterating as long as theres data
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
           if ($row['userStatus'])
           {
               echo "Online";
           }        
           else
           {
               echo "Offline";
           }
        }
    }
}


/*  ####################################### POST FUNCTIONS ####################################### */

// Function to display last forum posts
function displayLastPosts()
{
    echo "<h2 class='h2Titles'> Last Posts</h2>";
    require("db_con.php");

    // We display all posts, ordered by last posted and limit of 10
    $sql = "select DISTINCT thread_id from (select * from post group by postDate order by postDate desc) alias limit 7";
    
    $result = mysqli_query($link, $sql);
    mysqli_close($link);
    $resultCheck = mysqli_num_rows($result);

        // Here we show all posts that exists in our db
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $threadID = $row['thread_id'];
            $threadTitle = getThreadTitleById($threadID);
            $category = getCategoryIDbyThreadID($threadID);
           
?>
                        

                        <div class="windowMain">
                            <div class="lastPostTitle">
                                    <?php
                                        echo "<a href='index.php?viewcategory=$category&viewtopic=$threadID'>". $threadTitle . "</a><br>";

                                    ?>
                            </div>
                            <div class="postDateMain">
                                    <?php
                                        displayPostDateByThreadID($threadID) . "</p><div style='clear: both'></div>";
                                    ?>
                            </div>
                        </div>

                          
                     
<?php
        }
    }
}


// Function to display the date of a post from a thread id
function displayPostDateByThreadID($threadID)
{
    require("db_con.php");
    $sql = "SELECT postDate FROM post where thread_id='$threadID' ORDER BY postDate desc limit 1";
    
    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);
         mysqli_close($link);
          // We will keep iterating as long as theres data
          if ($resultCheck > 0)
          {
                while ($row = mysqli_fetch_assoc($result))
                {
                    echo $row['postDate'];
                }
            
          }
    }
}

// Function to display the last forum post in a category
function displayLastForumPost($category)
{
    require("db_con.php");
    $sql = "SELECT DISTINCT id from (select * from thread where category_id='$category' group by postDate order by postDate desc) alias limit 1";

    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);
         mysqli_close($link);
          // We will keep iterating as long as theres data
          if ($resultCheck > 0)
          {
            while ($row = mysqli_fetch_assoc($result))
        {
            $threadID = $row['id'];
            $threadTitle = getThreadTitle($threadID);
            $category = getCategoryIDbyThreadID($threadID);
?>            
                               <?php
                                   echo "<a href='index.php?viewcategory=$category&viewtopic=$threadID'>". $threadTitle . "</a><br>";
                                /*    displayPostDateByThreadID($threadID); */
                               ?>
<?php
        }

          }
    }
}

// Function to check the user cooldown
function checkUserCooldown()
{
    require("db_con.php");
    $user = $_SESSION['login']['user'];
    $sql = "SELECT postCooldown from accounts where username='$user';";
    
    $result = mysqli_query($link, $sql);
    mysqli_close($link);  
    $resultCheck = mysqli_num_rows($result);
    
    // Here we show all posts that exists in our db
    if ($resultCheck > 0)
    {

        while($row = mysqli_fetch_assoc($result))
        {
            return $row['postCooldown'];
        }
    }

}

// Function to update user's cooldown after posting
function updateUserCooldown($user)
{
    require("db_con.php");
    $date = date('Y-m-d H:i:s');
    $sql = "UPDATE accounts SET postCooldown='$date' where username='$user';";
    executeQuery($sql);
}

// Function in charge of posting a message in the forum
function insertForumPost($post, $title = '', $thread_id = 0)
{
    date_default_timezone_set('Europe/Madrid');
    $user = $_SESSION['login']['user'];
    $account_id = getAccount_IDbyUsername($user);
    $date = date('Y-m-d H:i:s');
    $thread_id = $thread_id ?: getThreadIDByPostTitle($title);
    
    $cooldown = strtotime(checkUserCooldown());
    $now = strtotime($date);
    
    $time = round(abs($cooldown - $now) / 60,2);
    
        if ($time >= 0.17)
        {
           
            require("db_con.php");
            $post = mysqli_real_escape_string($link, $post);
            $sql = "INSERT INTO post (postDate, post, thread_id, accounts_id) 
            VALUES ('$date', '$post', '$thread_id',  '$account_id');";
            executeQuery($sql);  
            
            updateUserCooldown($user);
    
            $_SESSION['success'] = "Your post has been successfully posted.";

            header('Location: '.$_SERVER['REQUEST_URI']);

        }
        else
        {
            $_SESSION['error'] = "You have to wait 10 seconds before posting again.";
        }

}


// Function to display the post lists inside a specific category
function displayPosts()
{
    require("db_con.php");   
    $postID = $_GET['viewtopic'];    
    $category = $_GET['viewcategory'];
    $postTitle = getThreadTitle($postID);
   
    // Add pagination to the post display
    if (isset($_GET["page"]))
    {
         $pagination = $_GET["page"];
    }
    else
    {
        $pagination = 1; 
    }
   
    $results_per_page = 10;
    $start = ($pagination - 1) * $results_per_page;
    echo "<h2 class='h2Titles'>$postTitle</h2>";
    echo '<div class="navigationPanel">
    <a href="index.php?forum">Forum Categories</a> >> <a href="index.php?viewcategory='.$category.'">'  . getCategoryTitleByCategoryID($category).'</a> >>  <a href="index.php?viewcategory='.$category.'&viewtopic='.$postID.'">' . getThreadTitle($postID) .'</a>
</div>';
    // We display all posts, ordered by last posted and limit of 10
    $sql = "SELECT id, postDate, post, accounts_id, thread_id from post where thread_id='$postID' limit $start, $results_per_page;";
    $result = mysqli_query($link, $sql);
   
    $resultCheck = mysqli_num_rows($result);
    
    // Here we show all posts that exists in our db
    if ($resultCheck > 0)
    {

        while($row = mysqli_fetch_assoc($result))
        {

            $id = $row['accounts_id'];
            
            ?>  
                           
                                <div class="windowPost">
                                    <div class="post">
                                       <div class="userPart">
                                           <img alt="profile image" class="pfpic" src="<?php checkPFPById($id);?>" />
                                           <br>
                                           <div id="userInfo">
                                               <?php
                                               usernameSelect($id);
                                               echo "<br>";
                                                   echo "Status: <b>"; 
                                                   DisplayUserStatus($row['accounts_id']);
                                                   echo "</b>";
                                                
                                                   
                                                   echo "<br> Post Count: <b>" . countPostsByID($row['accounts_id']) . "</b>";
                                               ?>
                                           </div>
                                       </div>
                                       <div class="postPart">
                                           
                                           <?php
                                               echo $row['post'];
                                           ?>
                                       </div>
                                       <div id='postDate'>
                                            <?php
                                               echo $row['postDate'];
                                            ?>
                                       </div>
                                       <br><br>
                                     </div>
                                   </div>
                           
                                   
            
    <?php
        }
    }

    $category = $_GET['viewcategory'];


    $sql = "select count(id) as total from post where thread_id='$postID';";
    $result = mysqli_query($link, $sql);

    $row = mysqli_fetch_assoc($result); 
    $totalPages = ceil($row["total"] / $results_per_page); 
    mysqli_close($link);
    echo "<div id='pagination'>";

    for ($i=1; $i <= $totalPages; $i++)
    { 
        if ($i == $pagination)
        {
            echo "<b>";
        }
        echo "<a href='index.php?viewcategory=$category&viewtopic=$postID&page=$i'><span id='page'>".$i ."</a> </span>";
        if ($i == $pagination)
        {
            echo "</b>";
        }
    }
    echo "</div>";
    

}


/*  ####################################### THREAD FUNCTIONS ####################################### */

// Function to get the thread title by id
function getThreadTitleById($id)
{
    require("db_con.php");

    // We display all posts, ordered by last posted and limit of 10
    $sql = "select postTitle from thread where id='$id';";
    
    $result = mysqli_query($link, $sql);
    mysqli_close($link);
    $resultCheck = mysqli_num_rows($result);

        // Here we show all posts that exists in our db
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {                
            $postTitle = $row['postTitle'];
            return $postTitle;
        }
    }
}


// Function to count the total of threads in a specific category
function countTotalThreads($category)
{
    require("db_con.php");
    $sql = "select count(*) from thread where category_id='$category';";  

    $result = mysqli_query($link, $sql);

    mysqli_close($link);
   
    $data = mysqli_fetch_assoc($result);
    return $data['count(*)'];
}



// Function to get the thread title by thread id
function getThreadTitle($id)
{
    require("db_con.php");

    // We display all posts, ordered by last posted and limit of 10
    $sql = "select postTitle from thread where id='$id';";
    
    $result = mysqli_query($link, $sql);
    mysqli_close($link);
    $resultCheck = mysqli_num_rows($result);

    // Here we show all posts that exists in our db
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {                
            $postTitle = $row['postTitle'];
            return $postTitle;
        }
    }
}

// Function to create a thread
function insertForumThread($post, $title, $category)
{
    date_default_timezone_set('Europe/Madrid');
    $user = $_SESSION['login']['user'];
    $account_id = getAccount_IDbyUsername($user);
    $date = date('Y-m-d H:i:s');

    // Checking the current date against the database user's cooldown
    $cooldown = strtotime(checkUserCooldown());
    $now = strtotime($date);

    // Get the difference between those dates in minutes
    $time = round(abs($cooldown - $now) / 60,2);

    // Check user rank
    $rank = userRank($user);

    // If 10 seconds has passed
    if ($time >= 0.17)
    {
        // If the category is an admin restricted one
        if ($category > 3 && $category < 8)
        {
            if ($rank > 1)
            {
                $_SESSION['error'] = "You don't have enough permissions to open a thread in this category.";
            }
            else
            {
                require("db_con.php");

                $title = mysqli_real_escape_string($link, $title);
                $sql = "INSERT INTO thread (postTitle, postDate, accounts_id, category_id) 
                VALUES ('$title', '$date', '$account_id', '$category');";
                executeQuery($sql); 

                insertForumPost($post, $title);
            }
            
        }
        else
        {
            require("db_con.php");

            $title = mysqli_real_escape_string($link, $title);
            $sql = "INSERT INTO thread (postTitle, postDate, accounts_id, category_id) 
            VALUES ('$title', '$date', '$account_id', '$category');";
            executeQuery($sql); 

            insertForumPost($post, $title);
        }
        
    }  
    else
    {
        $_SESSION['error'] = "You have to wait 10 seconds before making a new thread.";
    }
    header('Location: '.$_SERVER['REQUEST_URI']);
    
} 


// Function to get the thread id by the post title
function getThreadIDByPostTitle($postTitle)
{
    require("db_con.php");

    // We display all posts, ordered by last posted and limit of 10
    $sql = "select id from thread where postTitle='$postTitle';";
    
    $result = mysqli_query($link, $sql);
    mysqli_close($link);
    $resultCheck = mysqli_num_rows($result);

        // Here we show all posts that exists in our db
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {                
            $id = $row['id'];
            return $id;
        }
    }
}


// Function to display threads in the forum
function displayThreads()
{
    require("db_con.php");   
    $category = $_GET['viewcategory'];
    echo "<h2 class='h2Titles'>Threads in ". getCategoryTitleByCategoryID($category) ."</h2>";
    echo '<div class="navigationPanel">
        <a href="index.php?forum">Forum Categories</a> >> <a href="index.php?viewcategory='.$category.'">'. getCategoryTitleByCategoryID($category).'</a>
    </div>';
    if (isset($_GET["page"]))
    {
         $pagination = $_GET["page"];
    }
    else
    {
        $pagination = 1; 
    }
   
    $results_per_page = 10;
    $start = ($pagination - 1) * $results_per_page;
    // We display all posts, ordered by last posted and limit of 10
    $sql = "Select id, postTitle, category_id, accounts_id, postDate from thread where category_id='$category' order by postDate desc limit $start, $results_per_page;";
    $result = mysqli_query($link, $sql);
   
    $resultCheck = mysqli_num_rows($result);

        // Here we show all posts that exists in our db
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
?>
            <div class="windowMain">
                <div class="lastPostTitle">
                        <?php
                            echo "<a href='index.php?viewcategory=$category&viewtopic={$row["id"]}'>  {$row['postTitle']} </a><br>";
                            echo "by <b>"; 
                            usernameSelect($row['accounts_id']);
                            echo "</b>";
                        ?>
                </div>
                <div class="postDate">
                        <?php
                            echo $row['postDate']. "<br>";
                        ?>
                </div>
            </div>
<?php
        }
    }

    $category = $_GET['viewcategory'];


    $sql = "select count(id) as total from thread where category_id='$category';";
    $result = mysqli_query($link, $sql);

    $row = mysqli_fetch_assoc($result); 
    $totalPages = ceil($row["total"] / $results_per_page); 
    mysqli_close($link);

    echo "<div id='pagination'>";

    for ($i=1; $i <= $totalPages; $i++)
    { 
        if ($i == $pagination)
        {
            echo "<b>";
        }
        echo "<a href='index.php?viewcategory=$category&page=$i'><span id='page'>".$i ."</a> </span>";
        if ($i == $pagination)
        {
            echo "</b>";
        }
    }
    echo "</div>";
}

/*  ####################################### CATEGORIES FUNCTIONS ####################################### */


// Function to get the category id by thread_id
function getCategoryIDbyThreadID($threadID)
{
    require("db_con.php");

    // We display all posts, ordered by last posted and limit of 10
    $sql = "select category_id from thread where id='$threadID';";
    
    $result = mysqli_query($link, $sql);
    mysqli_close($link);
    $resultCheck = mysqli_num_rows($result);

        // Here we show all posts that exists in our db
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
           $category = $row['category_id'];
           return $category;
        }
    }
}

// Function to get the category title by the category ID
function getCategoryTitleByCategoryID($categoryID)
{
    require("db_con.php");
    $sql = "select categoryTitle from category where id='$categoryID';";
    
    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);
         mysqli_close($link);
          // We will keep iterating as long as theres data
          if ($resultCheck > 0)
          {
                while ($row = mysqli_fetch_assoc($result))
                {
                    return $row['categoryTitle'];
                }
            
          }
    }
}

// Function to display the category title
function displayCategoryTitle()
{
    require("db_con.php");
    $category = $_GET['viewcategory'];
    $sql = "Select * from category where id='$category'";


    $result = mysqli_query($link, $sql);
    mysqli_close($link);
    $resultCheck = mysqli_num_rows($result);

    // Here we show all posts that exists in our db
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $categoryID = $row['id'];
            $title = getCategoryTitleByCategoryID($categoryID);

            return "$title";
        }
    }

}


/*  ####################################### NEWS FUNCTIONS ####################################### */


// Function to get update post from update category
function getUpdatesPosts()
{
    
    require("db_con.php");

    // We display all posts, ordered by last posted and limit of 10
    $sql = "select * from post inner join thread on post.thread_id = thread.id where thread.category_id='4' order by thread.postDate desc limit 1;";
    
    $result = mysqli_query($link, $sql);
    mysqli_close($link);
    $resultCheck = mysqli_num_rows($result);

        // Here we show all posts that exists in our db
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {   
            echo "<h2 class='h2Titles'>Last Update</h2>";

?>

                           <div class="windowPost">
                                    <div class="post">
                                      
                                       <div class="update_userPart">
                                           <img alt="profile image" class="pfpic" src="<?php checkPFPById($row['accounts_id']);?>" />
                                           <br>
                                           <div id="update_userInfo">
                                               <?php
                                               
                                               adminUsernameSelect($row['accounts_id']);
                                               echo "<br>";
                                               ?>
                                           </div>
                                       </div>
                                       <?php
                                            echo "<br><u><h2 class='h2Update'>".$row['postTitle']."</h2><br></u>";
                                       ?>
                                       <div class="update_postPart">
                                  
                                           <?php
                                               
                                               echo $row['post'];
                                           ?>
                                       </div>
                                       <div id='update_postDate'>
                                            <?php
                                               echo $row['postDate'];
                                            ?>
                                       </div>
                                       <br><br>
                                     </div>
                                     <?php
                                     
    echo "<div class='windowPostUpdate'><a href='index.php?viewcategory=6&viewtopic=".$row['thread_id']."'>View thread</a></div>";

                                     ?>
                                   </div>
<?php


        }
    }
}




// Function to get update post from update categories
function getDevelopmentPosts()
{
    
    require("db_con.php");
    echo "<h2 class='h2Titles'>News</h2>";
    // We display all posts, ordered by last posted and limit of 10
    $sql = "select * from post inner join thread on post.thread_id = thread.id where thread.category_id between 5 and 7 order by thread.postDate desc limit 3;";
    
    $result = mysqli_query($link, $sql);
    mysqli_close($link);
    $resultCheck = mysqli_num_rows($result);

        // Here we show all posts that exists in our db
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {   
            

?>

                           <div class="windowPost">
                                    <div class="post">
                                      
                                       <div class="update_userPart">
                                           <img alt="profile image" class="pfpic" src="<?php checkPFPById($row['accounts_id']);?>" />
                                           <br>
                                           <div id="update_userInfo">
                                               <?php
                                               
                                               adminUsernameSelect($row['accounts_id']);
                                               echo "<br>";
                                               ?>
                                           </div>
                                       </div>
                                       <?php
                                            echo "<br><u><h2 class='h2Update'>".$row['postTitle']."</h2><br></u>";
                                       ?>
                                       <div class="update_postPart">
                                  
                                           <?php
                                               
                                               echo $row['post'];
                                           ?>
                                       </div>
                                       <div id='update_postDate'>
                                            <?php
                                               echo $row['postDate'];
                                            ?>
                                       </div>
                                       <br><br>
                                     </div>
                                     <?php
                                            echo "<div class='windowPostUpdate'><a href='index.php?viewcategory=6&viewtopic=".$row['thread_id']."'>View thread</a></div>";

                                     ?>
                                   </div>
<?php


        }
    }
}

/*
################################################## API #############################################
*/

// Retrieve the points of the user
function getPoints($user)
{
    require("db_con.php");
    $sql = "SELECT points FROM accounts where username='$user';";
    
    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);

          // We will keep iterating as long as theres data
          if ($resultCheck > 0)
          {
            while ($row = mysqli_fetch_assoc($result))
            {
                return $row['points'];     
            }
          }
    }
    else
    {
        $_SESSION['error'] = "Couldn't display the value, contact an administrator.";
        exit();
    }
}

// Update the points of the user in the db by adding the game score to the current points
function updatePoints($gameScore)
{
    require("db_con.php");
    $user = $_SESSION['user'];
    $points = getPoints($user) + $gameScore;
    $sql = "UPDATE accounts SET points='$points' where username='$user';";
    if (!executeQuery($sql))
    {
       
        $_SESSION['error'] = "Couldn't update your score, contact an administrator.";
        exit();
    }
    else
    {
        $_SESSION['success'] = "Game score added to your profile";
    }
}


/*
################################################## Shop module #############################################
*/

// Function to buy skins from the store
function buySkin($user, $skin)
{
    $shopSkinID = checkShopSkinID($skin);
    $shopSkinName = checkShopSkinName($skin);

    if (checkUserSkin($user) == $shopSkinID)
    {
        $_SESSION['error'] = "You already have that item activated";
    }
    
    else
    {
        $userPoints = checkPoints($user);
        $itemPrice = checkShopSkinPrice($skin);

        if ($userPoints < $itemPrice)
        {
            $_SESSION['error'] = "You don't have enough points to buy this item";
        }
        else
        {
            updateUserPoints($user, $itemPrice);
            updateUserSkin($user, $shopSkinID);

            $_SESSION['success'] = "You successfully purchased the item $shopSkinName";
        }

    }

}

// Function that checks if the user is already using a skin
function checkUserSkin($user)
{
    require("db_con.php");
    $sql = "SELECT skin FROM accounts where username='$user';";
    
    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);

          // We will keep iterating as long as theres data
          if ($resultCheck > 0)
          {
            while ($row = mysqli_fetch_assoc($result))
            {
                return $row['skin'];     
            }
          }
    }
    else
    {
        $_SESSION['error'] = "Couldn't find the skin, contact an administrator.";
        exit();
    }
}

// Function that checks the shop skin ID
function checkShopSkinID($skin)
{
    require("db_con.php");
    $sql = "SELECT itemID FROM shop where itemName='$skin';";
    
    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);

          // We will keep iterating as long as theres data
          if ($resultCheck > 0)
          {
            while ($row = mysqli_fetch_assoc($result))
            {
                return $row['itemID'];     
            }
          }
    }
}

// Function that checks the shop skin name
function checkShopSkinNAME($skin)
{
    require("db_con.php");
    $sql = "SELECT itemName FROM shop where itemName='$skin';";
    
    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);

          // We will keep iterating as long as theres data
          if ($resultCheck > 0)
          {
            while ($row = mysqli_fetch_assoc($result))
            {
                return $row['itemName'];     
            }
          }
    }
}

// Function that checks the shop skin price
function checkShopSkinPrice($skin)
{
    require("db_con.php");
    $sql = "SELECT itemPrice FROM shop where itemName='$skin';";
    
    if(executeQuery($sql))
    {
         $result = mysqli_query($link, $sql);
         $resultCheck = mysqli_num_rows($result);

          // We will keep iterating as long as theres data
          if ($resultCheck > 0)
          {
            while ($row = mysqli_fetch_assoc($result))
            {
                return $row['itemPrice'];     
            }
          }
    }
}

// Function to substract points from the user (used in the store, mainly)
function updateUserPoints($user, $points)
{
    require("db_con.php");
    $points = getPoints($user) - $points;
    $sql = "UPDATE accounts SET points='$points' where username='$user';";
    executeQuery($sql);
}

// Function to substract points from the user (used in the store, mainly)
function updateUserSkin($user, $skinID)
{
    require("db_con.php");
    $sql = "UPDATE accounts SET skin='$skinID' where username='$user';";
    executeQuery($sql);
}





?>

