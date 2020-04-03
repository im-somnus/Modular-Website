<?php
    // Home 
    if (isset($_GET['profile']))
    include("./public/main/private/profileModule.php");

    // Forum 
    elseif (isset($_GET['forum']))
        include('forum/forumModule.php');
    elseif (isset($_GET['viewcategory']))
        include('forum/threadModule.php');
    
    // Shop
    elseif (isset($_GET['shop']))
        include('shop/shopModule.php');
    elseif (isset($_GET['points']))
        include('shop/pointsModule.php');
    elseif (isset($_GET['buy']))
        include('shop/buyModule.php');
    
    // News
    elseif (isset($_GET['news']))
        include('news/newsModule.php');
    elseif (isset($_GET['updates']))
        include('news/updatesModule.php');

    // Game
    elseif (isset($_GET['overview']))
        include('game/overviewModule.php');
    elseif (isset($_GET['videos']))
        include('game/videosModule.php');

     // admin panel
    elseif (isset($_GET['admPan']))
        include('private/adm/admModule.php');

    // Login
    elseif (isset($_GET['login']))
        echo "You must be logged in to view this content.";

    
    else
    {   
        // Call function to display last posts and who's online
        displayLastPosts();
        displayOnlineUsers();
    }
?>