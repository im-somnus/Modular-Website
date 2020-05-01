<?php

/* 
    Module that acts as the entry point of the user's input for the MAIN content of the page
*/
    // Home 
    if (isset($_GET['profile']))
        // In charge of displaying the profile module
        include("./public/main/private/profileModule.php");

    // Forum 
    elseif (isset($_GET['forum']))
        // In charge of displaying the forum categories 
        include('forum/forumModule.php');
    elseif (isset($_GET['viewcategory']))
        // In charge of displaying the forum threads on each category
        include('forum/threadModule.php');
    
    // Game
    elseif (isset($_GET['game']))
        // Loads our game
        include('game/game.php');

    // News
    elseif (isset($_GET['news']))
        // In charge of displaying the news (automatically exported from the NEWS forum)
        include('news/newsModule.php');
    elseif (isset($_GET['updates']))
        // In charge of displaying the last update (automatically exported from the NEWS forum)
     include('news/updatesModule.php');

    // Shop
    elseif (isset($_GET['shop']))
        // In charge of displaying the store    
        include('shop/shopModule.php');
    elseif (isset($_GET['points']))
        // In charge of displaying the module in charge of explaining the point system
        include('shop/pointsModule.php');
    elseif (isset($_GET['buy']))
        // In charge of displaying the "buy points" (aka donations) module
        include('shop/buyModule.php');
    
    
     // Admin panel
    elseif (isset($_GET['admPan']))
        // Redirects to the admin panel
        header("location: public/main/private/adm/admModule.php ");

    // Login
    elseif (isset($_GET['login']))
    {
        $_SESSION['error'] = "You must be loggerd in to view this content";
        header("location: index.php");
    }
    // If we are not displaying anything of the above, means we are on the website main page
    else
    {   
        // Call function to display last posts and who's online list
        displayLastPosts();
        displayOnlineUsers();
    }
?>