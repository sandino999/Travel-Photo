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
		
		if ($val->run(array('username'=>$username,'password'=>$password) ))
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
			return  $val->error('username')."\n".$val->error('password');		
		}
	}
	
	/**
	 *  validate function for register. Uses phpfuel validation class 
	 *  paremeters: username, password, email, retype password, name
	 */
	
	public function validate_register($parameters)
	{
                /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                 * 
                 * Why Redeclare variables if you can use Parameters?
                 * note::edited 11/4/12
                 *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                 */
		$username = $parameters['username'];
		$password = $parameters['password'];
		$email = $parameters['email'];
		$retype = $parameters['retype'];
		$name = $parameters['name'];
	
		$val = Validation::forge();			// starts validation using fuelphp validation class
		
		$val->add_field('username','username','required|min_length[2]');
		$val->add_field('password','password','required|min_length[8]')->add_rule('match_field','retype');
		$val->add_field('email','email','required|min_length[2]|valid_email');
		$val->add_field('retype','retype password','required|min_length[8]');
		$val->add_field('name','name','required|min_length[2]');
		
                /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                 * 
                 * If the $_POST keys are the same as the one declared in the validation
                 * There's no need to declare them again in the $val->run()
                 * note: edited 11/4/12
                 * Suggestion =  We can just AJAX the validation instead doing two types of validation in JS.
                 * 
                 *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                 */
                
		if ($val->run(array('username'=>$username,'password'=>$password,'email'=>$email,'retype'=>$retype,'name'=>$name)))
		{
		 	
			$validate_username = $this->check_if_username_exists($val->validated('username'));	// calls function to check if username exists in the database
			$validate_email = $this->check_if_email_exists($val->validated('email'));			// calls function to check if email exists in the database
			
                       
                        /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                         * 
                         * Use match_field instead of this if statement. 
                         * 
                         * http://docs.fuelphp.com/classes/validation/validation.html
                         * note: added match field for if password != retype 11/4/12
                         *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                         */
									 
			if($validate_email == true)			// checks if email exists in  the database
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
				$this->add_register_to_db($val->validated('username'),$val->validated('password'),$val->validated('name'),$val->validated('email'));	
			}		
		}
		else
		{	
			return 	$val->error('username')."\n".$val->error('password')."\n"
					.$val->error('email')."\n".$val->error('retype')."\n".$val->error('name');
		}		
	}
	
	/**
	 *  validate_update function for edit profile
	 *  paremeters: file_name, file_size, file_tmp, name,username,email
	 */
	
	public function validate_update($parameters)
	{
		echo Session::instance()->get('email');
		$validate_email = $this->check_email_update($parameters['email']);		// calls function to check if email exists
                	
		
		
		if($parameters['name'] == '' OR $parameters['email'] == '')		
		{
			$error_type = 6;
			return $this->get_error_message($error_type);
		}
		elseif($validate_email == true)						// check if email already exists in the database
		{
			$error_type = 3;
			return $this->get_error_message($error_type);
		}
		elseif($parameters['photo'] == '')			
		{												
			$query = DB::update('users')->set(array('email'=>$parameters['email'],
			'name'=>$parameters['name']))->where('id','=',Session::get('user_id'))->execute();	
		}	
		else
		{
			
			$query = DB::update('users')->set(array('photo'=>$parameters['photo'],'date'=>date('d-m-Y'),
			'email'=>$parameters['email'],'name'=>$parameters['name']))->where('id','=',Session::get('user_id'))->execute();	
			
			$this->set_session_parameters(Session::get('username'));  // updates session
		}
	}
	
	/** 
	 *   validate_recover_password checks whether username and password exists in the database
	 *	 parameters: username, email
	 */
	
	public function validate_recover_password($username,$email)
	{
            /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             *
             * Don't QUERY everything. Query what you need, don't loop on the data. 
             * Waste of resources. 
             * note: edited 11/4/12
             *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             */
		
		$query = DB::select('user')->from('users')->where(array('user'=>$username,'email'=>$email))->execute();
		
		if(count($query) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
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
		elseif(strlen($password) < 8)
		{
			$error_type = 9;
			return $this->get_error_message($error_type);
		}
		else
		{
			$username =  $this->get_username($id);
			$hash_password = $this->hash_password($username,$password);
			DB::update('users')->set(array('pass'=>$hash_password))->where('pass','=',$id)->execute();
		}
	}
	
	/** 
	 *   function that validates password edit
	 *	 parameters: old password, new password, retype password
	 */
	
	public function validate_password_edit($password)
	{
		$validate_old_pass = $this->check_if_password_exists($password['old']);		// calls a function to check if old password match in database
		
		if($validate_old_pass == false)
		{	
			$error_type = 10;
			return $this->get_error_message($error_type);
		}
		elseif($password['new'] != $password['retype'])
		{
			$error_type = 2;
			return $this->get_error_message($error_type);
		}
		elseif(strlen($password['new']) < 8)
		{
			$error_type = 9;
			return $this->get_error_message($error_type);
		}
		else
		{
			$id = Session::get('user_id');
			$username = Session::get('username');
			$hash_password = $this->hash_password($username,$password['new']);
			
			DB::update('users')->set(array('pass'=>$hash_password))->where('id','=',$id)->execute();	
		}
	}

	/** 
	 *   check_login_db checks whether validated username and validated password match records existing in the database
	 *	 parameters: validated username, validated password
	 */

	public function check_login_db($username,$password)
	{
            /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             *
             * Don't QUERY everything. Query what you need, don't loop on the data. 
             * Waste of resources. 
             * note: edited 11/4/12
             *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             */
		$password = $this->hash_password($username,$password);
		
		$query =  DB::select()->from('users')->where(array('user'=>$username,'pass'=>$password))->execute();
		
		if(count($query) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	/** 
	 *   check_if_username_exists checks whether username already exists in the database
	 *	 parameters: username
	 */
	
	public function check_if_username_exists($username)
	{
            /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             *
             * Don't QUERY everything. Query what you need, don't loop on the data. 
             * Waste of resources. 
             * note: edited 11/4/12
             *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             */
			 
		$query = DB::select('user')->from('users')->where('user','=',$username)->execute();
		
		if(count($query) > 0)
		{
			return true;
		}
		else
		{	
			return false;
		}
	}
	
	/** 
	 * function that adds the registration fields to db after validation
	 *	 parameters: username,password,name,email
	 */
	
	public function add_register_to_db($username,$password,$name,$email)
	{
		$password_sha = $this->hash_password($username,$password);  // calls function hash_password to hash the password with username as salt
				$query = DB::insert('users');	
				$query->set(array(
						'user'=> $username,
						'pass'=> $password_sha,
						'name'	  => $name,
						'email'	  => $email,
						'photo'   => 'default.gif'
						)
				);
		$query->execute();
	}
	
	/** 
	 *   function checks if username exists in database for update profile
	 *	 It checks if record exists except the original username
	 *	 parameters: username
	 */
	
	public function check_username_update($username)
	{
            /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             *
             * You can do look for query on a specific value. Please do it on others.
             * 
             *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             */
		$query = DB::select('user')->from('users')->where('user','!=',Session::get('username'))->where('user','=',$username)->execute();
		
		if(count($query) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	/** 
	 *   check_if_email_exists checks whether email already exists in the database
	 *	 parameters: email
	 */
	
	public function check_if_email_exists($email)
	{
            /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             *
             * Don't QUERY everything. Query what you need, don't loop on the data. 
             * Waste of resources. 
             * note : edited 11/4/12
             *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             */
		
		$query = DB::select('email')->from('users')->where('email','=',$email)->execute();
		
		if(count($query)>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/** 
	 *   this function checks whether email exists in the database for update profile
	 *   It checks if record exists except the original email
	 *	 parameters:
	 */
	
	public function check_email_update($email)
	{
		
		$query = DB::select('email')->from('users')->where('email','!=',Session::get('user_email'))->where('email','=',$email)->execute();
			
		if(count($query) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
	/** 
	 *   function that checks whether old password of user exists in the database
	 *	 parameters: password
	 */
	
	public function check_if_password_exists($password)
	{
            /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             *
             * Just query the password. No need to look for the ID then look for the password.
             *  note: edited 11/4/12
             *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             */
		$username = Session::get('username');
		
		$password = $this->hash_password($username,$password); // hashes password to compare in database
		
		
		$query = DB::select('pass')->from('users')->where('pass','=',$password)->execute();
		
			if(COUNT($query)>0)
			{
				return true;
			}
			else
			{
				return false;
			}
	}
	
	/** 
	 *   get_server_name returns the server name for the machine used
	 *	 parameters:
	 */
	
	public function get_server_name()
	{
            /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             *
             * Why?
             * note: I used this for the link in email in the forgot password 
			 *	
             *!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
             */
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
	 *   get_username returns the username of the users 
	 *	 parameters: $id
	 */
	
	public function get_username($id)
	{
		$query = DB::select()->from('users')->where('pass','=',$id)->execute();
		
		foreach($query as $row)
		{
			return $row['user'];
		}	
	}
	
	/** 
	 *   get_profile settings returns the profile status of the users
	 *	 parameters: $id
	 */
	
	public function get_profile_settings($id)
	{
		$query = DB::select()->from('users')->where('id','=',$id)->execute()->as_array();
		return $query;
	}
	
	/** 
	 *   function that gets the stored hashed password of a users in the database
	 *	 parameters: email
	 */	
	
	public function get_hashed_password($email)
	{
		$query = db::select()->from('users')->where('email','=',$email)->execute();
		
		foreach($query as $row)
		{
			return $row['pass'];
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
			case 9:
				return 'Password must have 8 characters in length';
			case 10:
				return 'old password does not match in our server';
				
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
	}
	
	/** 
	 *   function that sets all the session parameters retrieved from the database where account is username parameter 
	 *	 parameters: username
	 */	
	 	
	public function set_session_parameters($username)
	{
		$server_name = $this->get_server_name();
		Session::instance()->set('server',$server_name);
		
		$query = DB::select()->from('users')->where('user','=',$username)->execute();
		
		Session::instance();
		
		foreach($query as $row)
		{
			Session::set('user_id',$row['id']);
			Session::set('username',$row['user']);
			Session::set('user_email',$row['email']);
			Session::set('user_photo',$row['photo']);
			Session::set('photo_date',$row['date']);
		}	
	}
	
	/*
	*	dummy model for follow
	*/
	
	public function follow($username,$follow_id)
	{
		$query = DB::insert('follows');
		$query->set(array(
					'username'=>$username,
					'follow'=>$follow_id
					)
		);
		$query->execute();
	}
	
	public function unfollow($username,$follow_id)
	{
		DB::delete('follows')->where(array('username'=>$username,'follow'=>$follow_id))->execute();
	}

}
