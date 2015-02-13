<?php
	session_unset();
	foreach($_SESSION as $key=>$val)
		unset($_SESSION[$key]);
	session_destroy();
	header("Location: index.php");
?>

