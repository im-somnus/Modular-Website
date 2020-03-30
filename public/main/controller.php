<div class="container">
		<header>
			<div>
				<div class="menu">
					
				</div>
			    <div id="logo">
					<?php
							include("public/header/logoModule.php"); 
					?>
				</div>
				<div class="windowLogin">
						
							<?php
									include("public/header/private/loginModule.php");
							?>
				</div>
			</div>
		</header>
		<nav>
                <?php
                        include("public/nav/navbarModule.php");
                ?>
        </nav>
        <main>
			<div class="windowAlert">
				<?php
						include("public/main/private/alertMessageModule.php");
				?>
			</div>
			<div class="windowMain">
				<?php
						include("public/main/mainModule.php");
				?>
			</div>
        </main>
		<footer>
			<div class="windowFooter">
				<?php
					include("public/footer/footerModule.php"); 
				?>
			</div>
		</footer>
</div>