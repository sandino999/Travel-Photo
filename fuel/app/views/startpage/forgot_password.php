
<html>
<head>
		
</head>
<body>
	
	<div style="position:relative; top:200;height:0px;left:700">
	<font color='red'><?php echo $message; ?></font>
		
		<form action='recover' method='post'>
			Username <input type='text' name='username'> <br/>
			Email  <input type='text' name='email'> <br/>
			<input type='submit' value='send'>	
		</form>	
		
		<?php echo Fuel\Core\Html::anchor('login','Back');?>
	</div>
	
	
	
</body>
</html>
