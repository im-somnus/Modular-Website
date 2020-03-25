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
			<div class="menu">
				<?php
						include("public/main/private/alertMessageModule.php");
				?>
			</div>
			<div class="menu">
				<?php
						include("public/main/mainModule.php");
				?>
			</div>
        </main>
		<footer>
			<?php
				include("public/footer/footerModule.php"); 
			?>
		</footer>