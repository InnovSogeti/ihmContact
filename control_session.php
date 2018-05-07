<?php
	if(!isset($_SESSION['groupe'])){
		echo '<p>Vous devez vous <a href="authentification.php">connecter</a>. pour accéder à cette page</p>'."\n";
		exit();
	}
?>