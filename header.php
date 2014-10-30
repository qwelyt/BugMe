<?php
	require 'connection.php';
	//Start session
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php 
			if(isset($_POST['logout'])){
				if(isset($_SESSION['usr'])){
					session_destroy();
					echo '<meta http-equiv="refresh" content="0">'; // Reload the page so all variables get set straight.
				}
			}
		?>
				
	    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	    <link rel='stylesheet' type='text/css' href='style.css'>
		<title>
			BugMe
		</title>
	</head>
	<body>
