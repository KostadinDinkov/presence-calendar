<?php
	
    session_start();
	session_regenerate_id(true);

	if(!isset($_SESSION['username'])){
		header("Location: login.php");
		exit;
	}

	

?>


