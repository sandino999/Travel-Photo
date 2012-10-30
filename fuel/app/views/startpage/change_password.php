
<html>
<head>
		
</head>
<body>
	<div style="position:relative; top:200;height:0px;left:700">
		<font color ='red'><?php echo $message ?></font>
			<?php	echo Form::open('accounts/password_reset',array('id'=>'reset')); ?>
			<input type='hidden' name='id' value='<?php echo $id; ?>'>
			password <input type='password' name='password' id='password'><br/>	
			retype password <input type='password' name='retype' id='retype'><br/> 
			<input type='submit' value='reset'>
		</form>
	</div>
		
</body>
</html>
