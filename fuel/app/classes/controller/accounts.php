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
				
		$username =  input::post('username');
		$password = input::post('password');
		
		$error_message = $this->user->validate_login($username,$password);
		
		if($error_message != null)
		{
			echo nl2br($error_message);	
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
				'username'=> input::post('reg_username'),
				'password'=> input::post('reg_password'),
				'retype'  => input::post('reg_password2'),
				'name'	  => input::post('reg_name'),
				'email'   => input::post('reg_email')
		);
		
		$error_message = $this->user->validate_register($parameters);	
		
		if($error_message != null)
		{	
			echo nl2br($error_message);
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
		
		$validate = $this->user->validate_recover_password(input::post('forgot_username'),input::post('forgot_email'));
		
		if($validate == true)
		{
			$this->user->send_email(input::post('forgot_email'));
			echo 'Email sent';
		}
		else
		{
			$error_type = 5;
			$error_message = $this->user->get_error_message($error_type);
			echo $error_message;
			//recreturn Response::forge(View::forge('startpage/forgot_password',array('message'=>$error_message)));
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
				'email'		=> $_POST['txtemail']
		);
		
		$error_message = $this->user->validate_update($parameters);	
		
		if($error_message == null)
		{
		/*
			$message_type = 4;
			$message = $this->user->get_message($message_type);
			echo $message; // dummy echo*/
			
			Response::redirect('');
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
	
	/*
	*	function for logout. Destroys all session
	*/
	
	public function action_logout()
	{
		Session::destroy();
		Response::redirect('');
	}
	
	public function action_redirect()
	{
		Response::redirect('');
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
	
	
	
	
	/* 
	*
	* temporary function for follow system
	*/
	
	public function action_follow()
	{
		return Response::forge(View::forge('dummy_view/follow'));
	}
	
	public function action_follow_db()
	{
		if(isset($_POST['follow_username']))
		{
		
			$username = $_POST['follow_username'];
			$follow_id = $_POST['follow_user_id'];
			
			$this->user->follow($username,$follow_id);
		}
		elseif(isset($_POST['unfollow_username']))
		{	
	
			$username = $_POST['unfollow_username'];
			$follow_id = $_POST['unfollow_user_id'];
					
			$this->user->unfollow($username,$follow_id);
		}
	}
	
	
}
