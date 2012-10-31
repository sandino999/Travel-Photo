
<html>
<head>
		
		
</head>
<body>
	
	<div style="position:relative; top:200;height:0px;left:700">
		<font color='red'><?php echo nl2br($message); ?></font>
		<font color='red'><span id='return_error'></span></font>
	
		<form action='register_validate' method='post' id='register'>
			username <input type='text' name='username' id='username'> 
			<font color='red'><span id='return_username'></span></font><br/>
			
			password <input type='password' name='password' id='password'> 
			<font color='red'><span id='return_password'></span></font><br/>
			
			retype password <input type='password' name='retype' id='retype'> 
			<font color='red'><span id='return_retype'></span></font><br/>
			
			name <input type='text' name='name' id='name'>	
			<font color='red'><span id='return_name'></span></font><br/>
			
			email <input type='text' name='email' id='email'>
			<font color='red'><span id='return_email'></span></font><br/>
			<input type='submit' value='register' id='btnreg'>
		</form>
		
		<?php echo Fuel\Core\Html::anchor('login','Back');?>
		
	
		
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<?php echo \Fuel\Core\Asset::js('validate.js'); ?>	
	</div>
</body>
</html>
