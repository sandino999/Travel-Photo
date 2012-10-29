
<html>
<head>
		
</head>
<body>
	
	<?php foreach($profile as $row) 
			{
				$server_name =  Session::instance()->get('server');				
				$photo = $server_name.'/travel-photo/assets/img/profile_picture/'.$row['photo'];
				$email = $row['email'];
				$username = $row['username'];
				$name = $row['name'];
			}	
	?>
	<div style="position:relative; top:200;height:0px;left:700">
		
		<h1> Edit Account </h1>
		<font color='red'><?php echo $message; ?></font>	
		<form action="update" method="post" enctype="multipart/form-data" id='update'>	
			
			Email Address <input type='text' name='txtemail' value='<?php echo $email; ?>' id='email'>
			<font color='red'><span id='return_email'></span></font><br/>
			
			Password <input type = button value ='Change Password'><br/>
			
			Name <input type='text' name='txtname' value='<?php echo $name; ?>' id='name'> 
			<font color='red'><span id='return_name'></span></font><br/>
			
			Username <input type='text' name='txtuser' value='<?php echo $username; ?>' id='username'>
			<font color='red'><span id='return_username'></span></font><br/>
			
			Image <img src='<?php echo $photo; ?>' width=100 height=100>
			<input type='file' value='Upload Image' name='picture'><br/>
			<input type='submit' value='Save Profile'>
		</form>
	</div>
	
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<?php echo \Fuel\Core\Asset::js('validate.js'); ?>	
</body>
</html>
