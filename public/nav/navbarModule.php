<?php
    ob_start();
?>
<div class="wrapper">  
  <!--Navbar with dropdown menu-->
    <nav id="myNavbar" class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
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

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="index.php?overview" data-toggle="dropdown" class="dropdown-toggle">Game<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    <li><a href="index.php?overview">Overview</a></li>
                    <li><a href="assets\files\game.rar">Download</a></li>
                    </ul>
            </ul>
            
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="index.php?forum" data-toggle="dropdown" class="dropdown-toggle">Forum<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="index.php?forum">Forum</a></li>
                        <li><a href="index.php?code">Code of Conduct</a></li>
                    </ul>
            </ul>
            
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="index.php?news" data-toggle="dropdown" class="dropdown-toggle">News<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="index.php?news">News</a></li>
                        <li><a href="index.php?updates">Updates</a></li>
                        <li><a href="https://gitlab.com/Somnus/pintegrado/" target="_blank">Gitlab Repository</a></li>
                    </ul>
            </ul>
            
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

  