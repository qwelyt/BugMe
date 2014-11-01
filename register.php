<div id='register'>
	<b>Register</b>
	<form action='index.php' method='post'>
		<input type='text' name='realname' placeholder='Real name' required/><br>
		<input type='text' name='username' placeholder='Username (3 chars)' pattern='(\w|\W){3,}' required/><br>
		<input type='email' name='email' placeholder='Email' required /><br>
		<input type='password' name='password1' placeholder='Password' pattern='(\w|\W){3,}' onchange='password2.pattern=this.value;' required /><br>
		<input type='password' name='password2' placeholder='Repeat password' pattern='(\w|\W){3,}' required /><br>
		<input type='submit' name='register' value='Register' />
	</form>
</div><!-- register -->
