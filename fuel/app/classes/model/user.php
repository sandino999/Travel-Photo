<?php

	/** 
	 *   Model_User for handles data for User login,registration and validation
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
				echo "valid username and password";
			}
			else
			{
				echo 'invalid username password';
			}
		}
		else
		{
			echo $val->error('username').'<br/>';
			echo $val->error('password');
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
		
		$val = Validation::forge();
		$val->add_field('username','username','required|min_length[3]');
		$val->add_field('password','password','required|min_length[8]');
		$val->add_field('email','email','required|min_length[3]|valid_email');
		$val->add_field('retype','retype password','required|min_length[8]');
		$val->add_field('name','name','required|min_length[3]');
		
		if ($val->run(array('username'=>$username,'password'=>$password,'email'=>$email,'retype'=>$retype,'name'=>$name)))
		{
			$validate_username = $this->check_if_username_exists($val->validated('username'));	// calls function to check if username exists in the database
			$validate_email = $this->check_if_email_exists($val->validated('email'));			// calls function to check if email exists in the database
			
			if($val->validated('password') != $val->validated('retype'))
			{
				echo 'password does not match';
			}
			elseif($validate_email == true)
			{
				echo 'email already exists in the database';
			}
			elseif($validate_username == true)
			{
				echo 'username already exists in the database';
			}
			else
			{
				$password_sha = $this->hash_password($val->validated('username'),$val->validated('password'));
				
				$query = DB::insert('accounts');	
				$query->set(array(
						'username'=> $parameters['username'],
						'password'=> $password_sha,
						'name'	  => $parameters['name'],
						'email'	  => $parameters['email']
						)
				);
				$query->execute();

				echo "registered";
			}
			
		}
		else
		{
			echo $val->error('username').'<br/>';
			echo $val->error('password').'<br/>';
			echo $val->error('email').'<br/>';
			echo $val->error('retype').'<br/>';
			echo $val->error('name').'<br/>';
		}
		
		/*
		$validate_username = $this->check_if_username_exists($parameters['username']);	// calls function to check if username exists in the database
		$validate_email = $this->check_if_email_exists($parameters['email']);			// calls function to check if email exists in the database
			
			if($parameters['username'] === '' OR $parameters['password'] === '' OR $parameters['name'] === '' OR $parameters['email'] === '') // check if all fields are empty
			{
				echo "Fill in missing Fields";
			}
			elseif($validate_username == true)
			{
				echo "username already exists";
			}
			elseif($parameters['password'] != $parameters['retype'])	// check if password and retype password match
			{
				echo "password do not match";
			}
			elseif($validate_email == true)		
			{
				echo "email already exists in database";
			}
			elseif(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $parameters['email']))  // check if a valid email
			{
				echo "Not a valid email";
			}
			else
			{
		
				$password_sha = $this->hash_password($parameters['username'],$parameters['password']);
				
				$query = DB::insert('accounts');	
				$query->set(array(
						'username'=> $parameters['username'],
						'password'=> $password_sha,
						'name'	  => $parameters['name'],
						'email'	  => $parameters['email']
						)
				);
				$query->execute();

				echo "Email sent";
			} */	
		
	}
	
	/**
	 *  validate_update function for edit profile
	 *  paremeters: file_name, file_size, file_tmp, name
	 */
	
	public function validate_update($parameters)
	{
	
		if($parameters['file_size'] > 1024 * 1024 * 4)  // check if file size exceeds 4mb
		{
			echo 'File Size exceeds 4mb';
		}
		elseif($parameters['file_size'] == 0)			// check if file size == 0
		{
			echo 'not an image file';
		}
		elseif(getimagesize($parameters['file_tmp']) == 0)	// getimagesize returns a non zero value if file is an image
		{
			echo 'not an image file';
		}
		else
		{
			$query = DB::update('accounts')->set(array('photo'=>$parameters['file_tmp']))->execute();
			echo 'account updated';
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
			return false;
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
	 *   function that hashes the password with username as salt
	 *	 parameters: username,password
	 */	
	
	public function hash_password($username,$password)
	{
		$salt = $username;
		$password = hash('sha256',$password.$salt);
		return $password;
	}
	
	public function get_hashed_password($email)
	{
		$query = db::select()->from('accounts')->where('email','=',$email)->execute();
		
		foreach($query as $row)
		{
			return $row['password'];
		}	
	}

}
