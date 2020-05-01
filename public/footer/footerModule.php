<!-- 
    Module in charge of the footer, it contains the same information as the nav bar, but its located at the bottom
      of the page. This makes it easier to navigate through the site once the content starts to grow inside Main.
 -->

 <div class="row">

  <!-- Home section -->
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

  <!-- GAME section -->
  <div class="column">
      <ul>
        <li><b><a href='index.php?game'>Play now!</a></b></li>
        <li><br></li>
        <br>
      </ol>
  </div>

  <!-- FORUM section -->
  <div class="column">
      <ul>
        <li><b><a href="index.php?forum">Forum</a></b></li>
        <li> <a href="index.php?code">Code of Conduct</a></li>
        <br>
      </ol>
  </div>

  <!-- NEWS section -->
  <div class="column">
      <ul>
        <li><b><a href="index.php?news">News</a></b></li>
        <li><a href="index.php?updates">Updates</a></li>
        <li><a href="https://gitlab.com/Somnus/pintegrado/" rel="noreferrer target="_blank">Gitlab Repo</a></li>
      </ol>
  </div>

  <!-- SHOP section -->
  <div class="column">
      <ul>
        <li><b><a href="index.php?shop">Online store</a></b></li>
        <li><a href="index.php?buy">Buy points!</a></li>
        <li><a href="index.php?points">Point system</a></li>
      </ol>
  </div>
</div>
<br>
