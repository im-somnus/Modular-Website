<?php

/* 
    Module in charge of the NAVBAR
*/

    // Turn on output buffering
    ob_start();
?>
<div class="wrapper">  
  <!-- Creating the navbar with a dropdown menu-->
    <nav id="myNavbar" class="navbar navbar-default" role="navigation">
    <!-- Mobile display navbar dropdown menu -->
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- Navbar links toggle -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <!-- Navbar Home -->
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="index.php" data-toggle="dropdown" class="dropdown-toggle">Home<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="index.php">Home</a></li>
                        <li>
                            <?php
                                if (!isset($_SESSION['login']))
                                {
                            ?>
                                        <a href="index.php?login">Profile</a>
                            <?php
                                }
                                else
                                { 
                            ?>
                                    <a href="index.php?profile">Profile</a>
                            <?php
                                }
                            ?>
                        </li>
                    </ul>
            </ul>
            <!-- Navbar GAME -->
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="index.php?game" data-toggle="dropdown" class="dropdown-toggle">Game<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    <li><a href="index.php?game">Play now!</a></li>
                    </ul>
            </ul>
            <!-- Navbar FORUM -->           
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="index.php?forum" data-toggle="dropdown" class="dropdown-toggle">Forum<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="index.php?forum">Forum</a></li>
                            <!-- Code of conduct will be a post in the forum -->       
                        <li><a href="index.php?viewcategory=3&viewtopic=13">Code of Conduct</a></li>
                    </ul>
            </ul>
            <!-- Navbar NEWS -->            
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="index.php?news" data-toggle="dropdown" class="dropdown-toggle">News<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="index.php?news">News</a></li>
                        <li><a href="index.php?updates">Updates</a></li>
                        <li><a href="https://gitlab.com/Somnus/pintegrado/" rel="noreferrer target="_blank">Gitlab Repository</a></li>
                    </ul>
            </ul>
            <!-- Navbar SHOP -->            
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="index.php?shop" data-toggle="dropdown" class="dropdown-toggle">Shop<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="index.php?shop">Online store</a></li>
                        <li><a href="index.php?buy">Buy points!</a></li>
                        <li><a href="index.php?points">Point system</a></li>
                    </ul>
            </ul>
        </div>
    </div>
    
    </nav>
    </ul>

    <!-- Navbar script in charge of hovering behaviour -->     
    <script type="text/javascript">
        $(document).ready(function()
        {
            $(".dropdown, .btn-group").hover(function()
            {
                var dropdownMenu = $(this).children(".dropdown-menu");
                if(dropdownMenu.is(":visible"))
                {
                    dropdownMenu.parent().toggleClass("open");
                }
            });
        });     
    </script>
  
  </div>

  