<?php
	
    session_start();
	session_regenerate_id(true);

	if(!isset($_SESSION['username'])){
		header("Location: index.php");
		exit;
	}

	

?>


