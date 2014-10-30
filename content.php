<?php
	if(isset($_SESSION['usr'])){
		include 'logOut.php';
		include 'whileIn.php';
	}
	else if(isset($_GET['register'])){
		include 'register.php';
	}
	else{
		include 'logIn.php';
	}
?>
