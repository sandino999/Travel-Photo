
<html>
<head>
		
</head>
<body>
		<div style="position:relative; top:200;height:0px;left:700">
		
		<font color='red'><?php echo $message; ?></font>

			<?php echo Form::open('accounts/login');	
			echo 'Username '.Form::input('txtusername','',array('id'=>'username')); 
			echo '<br/>Password '.Form::password('txtpassword');
			echo '<br/>'.Form::submit('Login','Login');
			echo Fuel\Core\Html::anchor('accounts/forgot_password', 'Forgot Password?');
			echo '<br/>'.Fuel\Core\Html::anchor('accounts/register', 'Register');
			echo form::close(); ?>
			
		</div>
	
</body>
</html>
