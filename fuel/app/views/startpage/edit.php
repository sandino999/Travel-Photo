
<html>
<head>
		
</head>
<body>
	
	<?php foreach($profile as $row) 
			{
				$photo = DOCROOT.'profile_picture\\'.$row['photo'];		
				$email = $row['email'];
				$username = $row['username'];
			}	
	?>
	
	<h1> Edit Account </h1>
	
		<form action="update" method="post" enctype="multipart/form-data">
			
			Email Address <input type='text' value='<?php echo $email; ?>'><br/>
			Password <input type = button value ='Change Password'><br/>
			<img src='<?php echo $photo; ?>'/>
			Image <input type='file' value='Upload Image' name='picture'> <br/>
			Name <input type='text' name='txtname'> <br/>
			Username <input type='text' name='txtuser' value='<?php echo $username; ?>'><br/>
			<input type='submit' value='Save Profile'>
			
		</form>

	
</body>
</html>
