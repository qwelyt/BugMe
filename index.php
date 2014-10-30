<?php
	include 'helpers.php';
	include "header.php";
	
	// Deal with registration
	$registerOK=true;
	$msg=''; // Msg output.

	// Check if user is trying to register
	if(isset($_POST['register'])){
		if(strlen($_POST['realname'])>0){ // Check if realname has been entered.
			if(strlen($_POST['email'])>0){ // Check if email has ben entered.
				if(strlen($_POST['username'])>2){ // Check if username is 3 chars or longer.
					if($_POST['password1'] == $_POST['password2']){ // Check if passwords match.
						$registerOK=true;
						$okToCreate=true; // Bool to check if we should create the user. Start off by being positive.
						// Clean inputs.
						$realname = $mysqli->real_escape_string(clean_input($_POST['realname']));
						$mail = $mysqli->real_escape_string(clean_input($_POST['email']));
						$username = $mysqli->real_escape_string(clean_input($_POST['username']));
						$password1 = $mysqli->real_escape_string(clean_input($_POST['password1']));
						$password2 = $mysqli->real_escape_string(clean_input($_POST['password2']));
						// Since we are paranoid, we do the checks again to see if we should create the user.
						if(!(strlen($realname)>0)){
							$okToCreate=false;
							$registrationOK=false;
							$msg="Real name not provided.";
						}
						if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
							$okToCreate=false;
							$registrationOK=false;
							$msg='Invalid email address.';
						}
						if(!(strlen($username)>2)){
							$okToCreate=false;
							$registrationOK=false;
							$msg='Username in not long enough.';
						}
						if($password1 !== $password2){
							$okToCreate=false;
							$registrationOK=false;
							$msg="Passwords don't match.";
						}

						// Try to reduce work for the database.
						if($okToCreate){
							// Check if username is taken.
							$query = $mysqli->prepare("SELECT username FROM users WHERE username=?");
							$query->bind_param('s', $username);
							$query->execute();
							$query = $query->get_result();
							if($query->num_rows > 0){
								$okToCreate=false;
								$msg='Username exists.';
							}
							
							// Hash the password.
							$password=password_hash($password1, PASSWORD_DEFAULT);

							if($okToCreate){// Since our checks seems to pass, create the user.
								$query = $mysqli->prepare("INSERT INTO `users`(`username`,`passwd`,`mail`,`realname`) VALUES(?,?,?,?)");
								$query->bind_param('ssss', $username, $password, $mail, $realname);
								$query->execute();
								if($query){
									$msg='Welcome '.$username.' . Your account has been created.';
								}else{
									$msg='Registration failed.';
									$registrationOK=false;
								}
							}
						}
					}
					else{
						$registerOK=false;
						$msg="Passwords don't match.";
					}
				}
				else{
					$registerOK=false;
					$msg='Username is not long enough.';
				}
			}
			else{
				$registerOK=false;
				$msg='No email entered.';
			}
		}
		else{
			$registerOK=false;
			$msg='Real name not provided.';
		}
	}

	if(isset($_POST['login'])){
		// Clean our inputs.
		$user = $mysqli->real_escape_string(clean_input($_POST['usr']));
		$pass = $mysqli->real_escape_string(clean_input($_POST['pwd']));

		$query = $mysqli->prepare("SELECT passwd FROM users WHERE username=?");
		$query->bind_param('s',$user);
		$query->execute();
		$result = $query->get_result();
		$count = $result->num_rows;
		if($count==1){
			$hash = $result->fetch_array(MYSQLI_NUM)[0];
			if(password_verify($pass, $hash)){
				$_SESSION['usr'] = $user;
			}
		}
	}

	include "content.php";
	include "footer.php";
?>
