<?php 
	
	if(!isset($_COOKIE["zip"])){

	setcookie("no_log", 1, time() + (3));
	
	header('Location:index.php');
	}
	
?>