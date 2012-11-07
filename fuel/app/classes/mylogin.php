<?php

class mylogin{

	public static function login($username,$password) 
	{
		$error_message = $this->user->validate_login($username,$password);
		
		if($error_message != null)
		{
			echo nl2br($error_message);	
		}
	}
		
}