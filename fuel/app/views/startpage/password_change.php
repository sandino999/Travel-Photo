
<html>
<head>
		
</head>
<body>
	
	<div style="position:relative; top:200;height:0px;left:700">
	<font color='red'><?php echo $message; ?></font>
		
		<form action='password_validate' method='post'>
			Old <input type='password' name='old_passwd'> <br/>
			New  <input type='password' name='new_passwd'> <br/>
			Retype <input type='password' name='retype_passwd'> <br/>
			<input type='submit' value='Change Password'>	
		</form>	
		
	</div>
	
	
	
</body>
</html>
