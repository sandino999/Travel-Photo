
<html>
<head>
		
</head>
<body>
	
	<form action='../password_reset' method='post'>
		<input type='hidden' name='id' value='<?php echo $id; ?>'>
		password <input type='password' name='password'> <br/>
		retype password <input type='password' name='retype'> <br/>	
		 <input type='submit' value='reset'>
	</form>
	
</body>
</html>
