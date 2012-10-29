<?php

	/** 
	 *   Model_User for handles data for User login, Registration, Forgot Password and Edit Profile Accounts 
	 *
	 */

class Model_User extends Model
{

	/**
	 *  validate function for login. Uses phpfuel validation class 
	 *  paremeters: username password
	 */
	
	public function validate_login($username,$password)
	{
		
		$val = Validation::forge();
		$val->add_field('username','username','required');
		$val->add_field('password','password','required');
		
		if ($val->run( array('username'=>$username,'password'=>$password) ))
		{
			$check = $this->check_login_db($val->validated('username'),$val->validated('password')); // calls function check_login_db to validate if validated username and password exists in database
			
			if($check == true)  
			{
				$this->set_session_parameters($username);	
			}
			else
			{
				$error_type = 1;
				return $this->get_error_message($error_type);
			}
		}
		else
		{		
			return $val->error('username').' '.$val->error('password');		
		}
	}
	
	/**
	 *  validate function for register. Uses phpfuel validation class 
	 *  paremeters: username, password, email, retype password, name
	 */
	
	public function validate_register($parameters)
	{
		$username = $parameters['username'];
		$password = $parameters['password'];
		$email = $parameters['email'];
		$retype = $parameters['retype'];
		$name = $parameters['name'];
		
		$val = Validation::forge();			// starts validation using fuelphp validation class
		
		$val->add_field('username','username','required|min_length[2]');
		$val->add_field('password','password','required|min_length[8]');
		$val->add_field('email','email','required|min_length[2]|valid_email');
		$val->add_field('retype','retype password','required|min_length[8]');
		$val->add_field('name','name','required|min_length[2]');
		
		if ($val->run(array('username'=>$username,'password'=>$password,'email'=>$email,'retype'=>$retype,'name'=>$name)))
		{
			$validate_username = $this->check_if_username_exists($val->validated('username'));	// calls function to check if username exists in the database
			$validate_email = $this->check_if_email_exists($val->validated('email'));			// calls function to check if email exists in the database
			
			if($val->validated('password') != $val->validated('retype'))	// checks if validated password == validated retype password
			{
				$error_type = 2;
				return $this->get_error_message($error_type);
			}
			elseif($validate_email == true)			// checks if email exists in  the database
			{
				$error_type = 3;
				return $this->get_error_message($error_type);
			}
			elseif($validate_username == true)		// checks if username exists in the database
			{
				$error_type = 4;
				return $this->get_error_message($error_type);
			}
			else
			{
				$password_sha = $this->hash_password($val->validated('username'),$val->validated('password'));  // calls function hash_password to hash the password with username as salt
				
				$query = DB::insert('accounts');	
				$query->set(array(
						'username'=> $parameters['username'],
						'password'=> $password_sha,
						'name'	  => $parameters['name'],
						'email'	  => $parameters['email'],
						'photo'   => 'default.gif'
						)
				);
				$query->execute();
			}	
		}
		else
		{	
			return 	$val->error('username').' '.$val->error('password').' '
					.$val->error('email').' '.$val->error('retype').' '.$val->error('name');
		}	
		
	}
	
	/**
	 *  validate_update function for edit profile
	 *  paremeters: file_name, file_size, file_tmp, name,username,email
	 */
	
	public function validate_update($parameters)
	{
		echo Session::instance()->get('email');
		$validate_username = $this->check_username_update($parameters['username']);	// calls function to check if username exists
		$validate_email = $this->check_email_update($parameters['email']);		// calls function to check if email exists
			
		$config = array(
		'path' => DOCROOT.'assets/img/profile_picture',		
		'auto_rename' => false,		
		'overwrite'   => false			//allow overwrites of duplicate files
		);
		
		Upload::process($config);		// process validation of file
		
		if($parameters['username'] == '' OR $parameters['name'] == '' OR $parameters['email'] == '')		
		{
			$error_type = 6;
			return $this->get_error_message($error_type);
		}
		elseif($validate_username == true)					// check if username already exists in the database
		{
			echo $validate_username;
			$error_type = 4;
			return $this->get_error_message($error_type);
		}
		elseif($validate_email == true)						// check if email already exists in the database
		{
			$error_type = 3;
			return $this->get_error_message($error_type);
		}
		elseif($parameters['file_size'] > 1024 * 1024 * 4 )  // check if file size exceeds 1mb
		{
			$error_type = 7;
			return $this->get_error_message($error_type);
		}
		elseif($parameters['file_size'] == 0)			// check if there is a photo chosen, if no photo chosen just proceed to save since change photo is not necessary
		{												// if there is a photo uploaded, check if it is a proper image file
			Upload::save();
			$query = DB::update('accounts')->set(array('username'=>$parameters['username'],'email'=>$parameters['email'],
			'name'=>$parameters['name']))->where('id','=',Session::get('user_id'))->execute();	
		}
		elseif(getimagesize($parameters['file_tmp']) == 0)	// getimagesize returns a non zero value if file is an image
		{
			$error_type = 8;
			return $this->get_error_message($error_type);
		}
		else
		{
			Upload::save();
			$query = DB::update('accounts')->set(array('photo'=>$parameters['file_name'],'username'=>$parameters['username'],
			'email'=>$parameters['email'],'name'=>$parameters['name']))->where('id','=',Session::get('user_id'))->execute();	
		}
		
	}
	
	/** 
	 *   validate_recover_password checks whether username and password exists in the database
	 *	 parameters: username, email
	 */
	
	public function validate_recover_password($username,$email)
	{
		$query = DB::select()->from('accounts')->execute();
	
		foreach($query as $row)
		{
			if($row['username'] === $username AND $row['email'] === $email)
			{
				return true;
			}	
			
		}	
		return false;
	}
	
	/** 
	 *   validate_password validates the password and retype password 
	 *	 parameters: password, retype password
	 */
	
	public function validate_password($password,$retype,$id)
	{	
		if($password != $retype)
		{
			$error_type = 2;
			return $this->get_error_message($error_type);
		}
		elseif($password == '' OR $retype == '')
		{
			
			$error_type = 6;
			return $this->get_error_message($error_type);
		}
		else
		{
			$username =  $this->get_username($id);
			$hash_password = $this->hash_password($username,$password);
			DB::update('accounts')->set(array('password'=>$hash_password))->where('password','=',$id)->execute();
		}
	}

	/** 
	 *   check_login_db checks whether validated username and validated password match records existing in the database
	 *	 parameters: validated username, validated password
	 */

	public function check_login_db($username,$password)
	{
		$password = $this->hash_password($username,$password);
		
		$query =  DB::select()->from('accounts')->execute();
	
		foreach($query as $row)
		{
			if($row['username'] === $username AND $row['password'] === $password)
			{
				return true;
			}
		}			
		return false;
	}
	
	
	/** 
	 *   check_if_username_exists checks whether username already exists in the database
	 *	 parameters: username
	 */
	
	public function check_if_username_exists($username)
	{
		$query = DB::select('username')->from('accounts')->execute();
		
		foreach($query as $row)
		{
			if($row['username'] === $username)
			{
				return true;
			}
		}
			
		return false;
	}
	
	/** 
	 *   function checks if username exists in database for update profile
	 *	 It checks if record exists except the original username
	 *	 parameters: username
	 */
	
	public function check_username_update($username)
	{
		$query = DB::select('username')->from('accounts')->where('username','!=',Session::get('username'))->execute();
		
		foreach($query as $row)
		{
			if($row['username'] === $username)
			{
				return true;
			}
		}
			
		return false;
	}
	
	
	/** 
	 *   check_if_email_exists checks whether email already exists in the database
	 *	 parameters: email
	 */
	
	public function check_if_email_exists($email)
	{
		$query = DB::select('email')->from('accounts')->execute();
		
		foreach($query as $row)
		{
			if($row['email'] === $email )
			{
				return true;
			}
		}
		
		return false;
	}
	
	/** 
	 *   this function checks whether email exists in the database for update profile
	 *   It checks if record exists except the original email
	 *	 parameters:
	 */
	
	public function check_email_update($email)
	{
		echo Session::instance()->get('email');
		/*
		$query = DB::select('email')->from('accounts')->where('email','!=',Session::instance()->get('email'))->execute();
		
		foreach($query as $row)
		{
			if($row['email'] === $email)
			{
				return true;
			}
		}
			
		return false;*/
	}
	
	/** 
	 *   get_server_name returns the server name for the machine used
	 *	 parameters:
	 */
	
	public function get_server_name()
	{
		$protocol = 'http';
		
		if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') 
		{
			$protocol = 'https';
		}
	
		$host = $_SERVER['HTTP_HOST'];
		$baseUrl = $protocol . '://' . $host;
		
		if (substr($baseUrl, -1)=='/') 
		{
			$baseUrl = substr($baseUrl, 0, strlen($baseUrl)-1);
		}
	
		return $baseUrl;
	}
	
	/** 
	 *   get_username returns the username of the user 
	 *	 parameters: $id
	 */
	
	public function get_username($id)
	{
		$query = DB::select()->from('accounts')->where('password','=',$id)->execute();
		
		foreach($query as $row)
		{
			return $row['username'];
		}	
	}
	
	/** 
	 *   get_profile settings returns the profile status of the user
	 *	 parameters: $id
	 */
	
	public function get_profile_settings($id)
	{
		$query = DB::select()->from('accounts')->where('id','=',$id)->execute()->as_array();
		return $query;
	}
	
	/** 
	 *   function that gets the stored hashed password of a user in the database
	 *	 parameters: email
	 */	
	
	public function get_hashed_password($email)
	{
		$query = db::select()->from('accounts')->where('email','=',$email)->execute();
		
		foreach($query as $row)
		{
			return $row['password'];
		}	
	}
	
	/** 
	 *   get_error_message retrieve all the error message that is to be displayed in the view
	 *	 parameters: $error_type
	 */	
	
	public function get_error_message($error_type)
	{
		switch ($error_type)
		{
			case 1:
				return 'Invalid Username and Password';	
			case 2:
				return 'Password does not match';
			case 3:
				return 'Email already exists in the database';
			case 4:
				return 'Username already exists in the database';
			case 5:
				return 'Username and Email does not match in the database';
			case 6:
				return 'Fill in Missing Fields';
			case 7:
				return 'File Size exceeds 4mb';
			case 8:
				return 'Not an image file';
		}
	}
	
	/** 
	 *   get_message retrieve all the message that is to be displayed in the view
	 *	 parameters: $message_type
	 */	
	
	public function get_message($message_type)
	{
		switch($message_type)
		{
			case 1:
				return 'Registration Succesful';
			case 2:
				return 'You are now logged on';
			case 3:
				return 'Password Succefully Changed';
			case 4:
				return 'Account Updated';
		}
	}
	

	/** 
	 *   function that hashes the password with username as salt
	 *	 parameters: username,password
	 */	
	
	public function hash_password($username,$password)
	{
		$salt = $username;
		$password = hash('sha256',$password.$salt);
		return $password;
	}
	
	/** 
	 *   send_mail send the link to email parameter with the link to reset password page
	 *	 parameters: email address
	 */
	
	public function send_email($email_address)
	{
		$server_name = $this->get_server_name();
		$hash_password = $this->get_hashed_password($email_address);
		$link = $server_name.uri::base().'accounts/change_password/'.$hash_password;
	
		$email = Email::forge();
		$email->from('Travel-Photo','Travel-Photo');
		$email->to(array($email_address));
		$email->subject('Recover Password');
		$email->body('Click the link to this account to reset your password:'.$link);
		$email->send();
		
		echo "email sent";
	}
	
	/** 
	 *   function that sets all the session parameters retrieved from the database where account is username parameter 
	 *	 parameters: username
	 */	
	 	
	public function set_session_parameters($username)
	{
		$server_name = $this->get_server_name();
		Session::instance()->set('server',$server_name);
		
		$query = DB::select()->from('accounts')->where('username','=',$username)->execute();
		
		Session::instance();
		
		foreach($query as $row)
		{
			Session::set('user_id',$row['id']);
			Session::set('username',$row['username']);
			Session::set('user_email',$row['email']);
		}	
	}
	
	

}
