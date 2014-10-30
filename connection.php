<?php
	require '../db.php';
	//Make connection
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $database);
	// Set charset to UTF-8, because this is not the 90s.
	$mysqli->set_charset('utf8');
?>
