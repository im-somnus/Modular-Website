        <header>
			<div>
				<div class="menu">
					<?php
							include("public/header/downloadModule.php"); 
					?>
				</div>
			    <div id="logo">
					<?php
							include("public/header/logoModule.php"); 
					?>
				</div>
				<div id="login">
						<?php
								include("public/header/private/loginModule.php");
						?>
				</div>
			</div>
		</header>
		<nav>
            <div class="menu">
                <?php
                        include("public/nav/navbarModule.php");
                ?>
            </div>
        </nav>
        <main>
			<?php
					include("public/main/private/errorModule.php");
					include("public/main/mainModule.php");
            ?>
        </main>
		<footer>
			<?php
				include("public/footer/footerModule.php"); 
			?>
		</footer>