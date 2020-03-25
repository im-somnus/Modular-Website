<ul>
    <li class="dropdown">
        <a href='index.php'>Home</a>
        <?php
            if (!isset($_SESSION['login']))
            {
        ?>
                <div>
                    <a href="index.php?login">Profile</a>
                </div>
        <?php
            }
        ?>
    </li>
<li class="separator"></li>
    <li class="dropdown">
        <a href='index.php?overview'>Game</a>
        <div>
            <a href="index.php?overview">Overview</a>
            <a href="index.php?videos">Videos</a>
            <a href="index.php?">Download</a>
        </div>
    </li>
<li class="separator"></li>
    <li class="dropdown">
            <a href="index.php?forum">Forum</a>
        <div>
            <a href="index.php?code">Code of Conduct</a>
        </div>
    </li>
<li class="separator"></li>
    <li class="dropdown">
            <a href="index.php?news">News</a>
        <div>
            <a href="index.php?updates">Updates</a>
            <a href="https://gitlab.com/Somnus/pintegrado/" target="_blank">Gitlab Repo</a>
        </div>
    </li>
<li class="separator"></li>
    <li class="dropdown">
            <a href="index.php?shop">Shop</a>
        <div>
            <a href="index.php?buy">Buy points!</a>
            <a href="index.php?shop">Online store</a>
            <a href="index.php?points">Point system</a>
        </div>
    </li>
</ul>