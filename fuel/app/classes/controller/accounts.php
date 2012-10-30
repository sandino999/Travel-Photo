<?php



class Controller_Accounts extends Controller
{
	
	public function __construct()
	{
		$this->user = new Model_user;
	}
	
	/**
	 * parameters username and password is submitted from login view
	 *
	 */
	 
	public function action_login()
	{
				
		$username =  input::post('txtusername');
		$password = input::post('txtpassword');
		
		$error_message = $this->user->validate_login($username,$password);
		
		if($error_message == null)
		{
			$message_type = 2;
			$logged = $this->user->get_message($message_type);
			echo $logged;			// dummy echo
		}
		else
		{
			return Response::forge(View::forge('startpage/login',array('message'=>$error_message)));	
		}
	}
	
	/**
	 * 	action_register set the view for the register page
	 */
	
	public function action_register()
	{
		$message = '';
		return Response::forge(View::forge('startpage/register',array('message'=>$message)));
	}
	
	/**
	 *  validate paremeters for register from register view
	 *  paremeters: username, password, name, email	
	 */
	
	public function action_register_validate()
	{
		
		$parameters = array(
				'username'=> input::post('username'),
				'password'=> input::post('password'),
				'retype'  => input::post('retype'),
				'name'	  => input::post('name'),
				'email'   => input::post('email')
		);
		
		$error_message = $this->user->validate_register($parameters);	
		
		if($error_message == null)
		{	
			$message_type = 1;
			$message = $this->user->get_message($message_type);
			echo $message;			// dummy echo
		}
		else
		{
			return Response::forge(View::forge('startpage/register',array('message'=>$error_message)));	
		}
		
	}
	
	/**
	 *  function displays the edit page
	 *  
	 */
	
	public function action_edit()
	{
		$error_message = '';
		$profile = $this->user->get_profile_settings(Session::get('user_id'));		
		return Response::forge(View::forge('startpage/edit',array('profile'=>$profile,'message'=>$error_message)));	
	}
	
	/**
	 *  function which displays forgot password page
	 * 
	 */
	public function action_forgot_password()
	{
		$message = '';
		return Response::forge(View::forge('startpage/forgot_password',array('message'=>$message)));
	}
	
	/**
	 *  function which validates reset password
	 *  paremeters: username, email
	 */
	
	public function action_recover()
	{
		$validate = $this->user->validate_recover_password(input::post('username'),input::post('email'));
		
		if($validate == true)
		{
			$this->user->send_email(input::post('email'));	
		}
		else
		{
			$error_type = 5;
			$error_message = $this->user->get_error_message($error_type);
			return Response::forge(View::forge('startpage/forgot_password',array('message'=>$error_message)));
		}
	}
	
	/**
	 *  function which updates accounts  
	 *  parameters:
	 */
	
	public function action_update()
	{
		
		$parameters = array(
				'file_name'=> $_FILES['picture']['name'],
				'file_size'=> $_FILES['picture']['size'],
				'file_tmp'  => $_FILES['picture']['tmp_name'],
				'file_error' => $_FILES['picture']['error'],
				'name'		=> $_POST['txtname'],
				'username'	=> $_POST['txtuser'],
				'email'		=> $_POST['txtemail']
		);
		
		$error_message = $this->user->validate_update($parameters);	
		
		if($error_message == null)
		{
			$message_type = 4;
			$message = $this->user->get_message($message_type);
			echo $message; // dummy echo
		}	
		else
		{
			$profile = $this->user->get_profile_settings(Session::get('user_id'));		
			return Response::forge(View::forge('startpage/edit',array('profile'=>$profile,'message'=>$error_message)));
		}
	}
	
	/**
	 * 
	 * display the change_password page
	 * 
	 */
	
	public function action_change_password($id)
	{
		$message = '';
		return Response::forge(View::forge('startpage/change_password',array('id'=>$id,'message'=>$message)));		
	}
	
	/**
	 * 
	 * function that display password change for edit profile
	 */
	
	
	public function action_password_change()
	{
		$message = '';
		return Response::forge(View::forge('startpage/password_change',array('message'=>$message)));
	}
	
	/**
	 * function that validates the fields for password edit
	 *	parameters : old password, new password, retype password
	 */
	
	public function action_password_validate()
	{
		$password = array(
			'old' => input::post('old_passwd'),
			'new' => input::post('new_passwd'),
			'retype' => input::post('retype_passwd')
		);
		
		$error_message = $this->user->validate_password_edit($password);
		
		if($error_message == null)
		{
			echo "Password Changed"; // dummy echo
		}
		else
		{
			return Response::forge(View::forge('startpage/password_change',array('message'=>$error_message)));
		}
	}
	
	/**
	 * function for password reset and validation
	 * paremeters: password, retype password
	 */
	
	public function action_password_reset()
	{
		$error_message = $this->user->validate_password(input::post('password'),input::post('retype'),input::post('id'));
		
		if($error_message == null)
		{
			$message_type = 3;
			$message = $this->user->get_message($message_type);
			echo $message;		// dummy echo
		}
		else
		{
			return Response::forge(View::forge('startpage/change_password',array('message'=>$error_message,'id'=>input::post('id'))));	
		}
	}

	
	/**
	 * The 404 action for the application.
	 * 
	 * @access  public
	 * @return  Response
	 */
	 
	public function action_404()
	{
		return Response::forge(ViewModel::forge('welcome/404'), 404);
	}
}
