<!--

This is the controller, divides the webpage into sections for an easier time dealing with the web code.

The header:
	Divided into 3 columns, the first one is empty, the other two are the logo and the login module.

The navbar:
	Divided into 5 columns, this module will help the user navigate through the site

MAIN:
	This is where the content will be loaded depending on the user's requests.
	It will include the modules in this area, without having to reload the rest of the website, 
		this helps with loading times, traffic, etc.

the footer: 
	Behaves like the navbar, but on the bottom of the web. It's another QoL for the user to help him
		navigate through our site.
-->

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