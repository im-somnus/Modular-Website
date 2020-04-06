<?php
session_start();
require("admFunctionLibrary.php");
require("../functionLibrary.php");
?>
            <div class="windowAlert">
				<?php
						include("../alertMessageModule.php");
				?>
            </div>
<?php
modifyAccounts();