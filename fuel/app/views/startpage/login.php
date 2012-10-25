
<html>
<head>
		
</head>
<body>
		<?php echo $message; ?>
	<div>
		<form action='./accounts/login' method='post'>
		Username
		<input type='text' name='txtusername' id='username'> <br/>
		Password 
		<input type='password' name='txtpassword' id='password'>
		<br/> <input type='checkbox' name='checklogin' id='checklog'> Keep me logged
	
		<input type='submit' value='Log In' id='submit'>
		<br/><a href='accounts/forgot_password'> Forgot Password? </a>
		<br/><a href='accounts/register'> register </a>
		</form>
	</div>
</body>
</html>
