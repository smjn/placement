<?php
	if(session_id() != '')
		if(!isset($_SESSION["user"]) || !isset($_SESSION["pass"]))
			header("Location: logout.php");
?>
