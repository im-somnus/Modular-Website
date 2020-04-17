<!-- This file is the module of the footer  -->
<div class="row">
  <div class="column">
      <ul>
        <li><b><a href='index.php'>Home</a></b></li>
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
        <li> </li>
      </ol>
  </div>
  <div class="column">
      <ul>
        <li><b><a href='index.php?overview'>Game</a></b></li>
        <li><a href="assets\files\game.rar">Download</a></li>
        <br>
      </ol>
  </div>
  <div class="column">
      <ul>
        <li><b><a href="index.php?forum">Forum</a></b></li>
        <li> <a href="index.php?code">Code of Conduct</a></li>
        <br>
      </ol>
  </div>
  <div class="column">
      <ul>
        <li><b><a href="index.php?news">News</a></b></li>
        <li><a href="index.php?updates">Updates</a></li>
        <li><a href="https://gitlab.com/Somnus/pintegrado/" rel="noreferrer target="_blank">Gitlab Repo</a></li>
      </ol>
  </div>
  <div class="column">
      <ul>
        <li><b><a href="index.php?shop">Online store</a></b></li>
        <li><a href="index.php?buy">Buy points!</a></li>
        <li><a href="index.php?points">Point system</a></li>
      </ol>
  </div>
</div>
<br>
