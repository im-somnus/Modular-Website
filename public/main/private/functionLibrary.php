<?php

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


// Validate the user input from login/register modules.
function validateUserInput($user, $pass)
{
    $pattern = "/^[A-Za-z0-9][A-Za-z0-9_-]{4,21}$/";
    // Check if username meets the minimum requirements.
    if (!preg_match($pattern, $user))
    {
        $_SESSION['error'] = "Username does not meet the requirements, try again";

        header("location: ../../../index.php");
        exit();
    }
    else
    {
        // Check if password meets the next pattern;
        $pattern = "/[@$%&.,A-Za-zçñ0-9_-]{6,20}$/";

        if (!preg_match($pattern, $pass))
        {
            $_SESSION['error'] = "Password does not meet the requirements, try again";

            header("location: ../../../index.php");
            exit();
        }
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
                      echo $row['points'];     
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
    
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile))
            {
                include("db_con.php");
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
                    echo "The image couldnt be changed, try again.";
                    header("Location: index.php?profile&edit");
                    exit();
                }

                mysqli_close($link);
                header("Location: index.php?profile");
                
            }
            else
            {
                echo "<br>Sorry, there was an error uploading your file.";
            }
    }
}    

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
                    if ($row['pfpicture'] == "default_pfpic.png")
                    {
                        echo "./assets/images/users/profilePictures/".$row['pfpicture'];
                    }
                    else
                    {
                        echo "./assets/images/users/profilePictures/$user/".$row['pfpicture'];
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
    include("db_con.php");
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
      include("db_con.php");
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


function countOnlineUsers()
{
    include("db_con.php");
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

function displayOnlineUsers()
{
    include("db_con.php");
    $sql = "SELECT username FROM accounts where userStatus='1';";  

    $result = mysqli_query($link, $sql);

    mysqli_close($link);
    echo "<h2>Who's online?</h2>";
    echo "Total number of users online: " . countOnlineUsers() . "<br><br> <b>Users:</b><br><br> ";
    $resultCheck = mysqli_num_rows($result);
    // We will keep iterating as long as theres data
    if ($resultCheck >= 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
             echo $row['username'] . ", ";
        }
    }
}



/*  ####################################### POST FUNCTIONS ####################################### */


function displayLastPosts()
{
    echo "<h2> Last Posts</h2>";
    include("db_con.php");

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
                        <div class="thread">
                           <div class="postPart">
                               <?php
                                   echo "<a href='index.php?thread=$category&viewtopic=$threadID'>". $threadTitle . "</a><br>";
                                   displayPostDateByThreadID($threadID);
                               ?>
                           <br><br>
                        </div>
                       </div>
<?php
        }
    }
}


// Function to display the date of a post from a thread id
function displayPostDateByThreadID($threadID)
{
    include("db_con.php");
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



/*  ####################################### THREAD FUNCTIONS ####################################### */

// Function to get the thread title by id
function getThreadTitleById($id)
{
    include("db_con.php");

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


/*  ####################################### CATEGORIES FUNCTIONS ####################################### */


// Function to get the category id by thread_id
function getCategoryIDbyThreadID($threadID)
{
    include("db_con.php");

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




?>