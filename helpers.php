<?php
	// Trim and fix input so we get rid of trailing whitespace,
	// We also strip out slashes and convert chars like < to their
	// html representation. Reduces risks of XSS.
	function clean_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


	// Try to set up a secure session.
	function sec_session_start(){
		$session_name = 'sec_session_id';
		$secure = true;

		// Stop js from accessing the session id.
		$httponly = true;

		// Force session to only use cookies.
		if(ini_set('session.use_only_cookies', 1) === false){
			exit();
		}

		$cookieParams = session_get_cookie_params();
		session_set_cookie_params(
			$cookieParams['lifetime'],
			$cookieParams['path'],
			$cookieParams['domain'],
			$secure,
			$httponly);

		//Set session name to the one above
		session_name($session_name);
		session_start();
		session_regenerate_id();
	}
?>
