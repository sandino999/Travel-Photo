<?php

	/** 
	 *   Model_User for handles data for User login,registration and validation
	 *
	 */

class Model_User extends Model
{

	
	/**
	 *  validate function for login 
	 *  paremeters: username password
	 */
	
	public function validate_login($username,$password)
	{
		$validate = $this->check_login_db($username,$password);    
		
			if($username === '' OR $password === '')
			{
				echo 'Fill in missing Fields';
			}
			elseif($validate == false)
			{
				echo 'Invalid username and password';
			}
			else
			{
				echo 'Username and Password match';
			}
	}
	
	/**
	 *  validate function for register 
	 *  paremeters: username, password, email, retype password, name
	 */
	
	public function validate_register($parameters)
	{
		
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
			}
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
	 *   check_login_db checks whether username and password match records existing in the database
	 *	 parameters: username, password
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
	 *   function that hashes the password with username as salt
	 *	 parameters: username,password
	 */
	
	public function hash_password($username,$password)
	{
		$salt = $username;
		$password = hash('sha256',$password.$salt);
		return $password;
	}

}
