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

		$username =  $_POST['txtusername'];
		$password = $_POST['txtpassword'];
		
		$this->user->validate_login($username,$password);
	}
	
	/**
	 * 	action_register set the view for the register page
	 */
	
	public function action_register()
	{
		return Response::forge(View::forge('startpage/register'));
	}
	
	/**
	 *  validate paremeters for register from register view
	 *  paremeters: username, password, name, email	
	 */
	
	public function action_register_validate()
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$retype = $_POST['retype'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		
		$parameters = array(
				'username'=> $_POST['username'],
				'password'=> $_POST['password'],
				'retype'  => $_POST['retype'],
				'name'	  => $_POST['name'],
				'email'   => $_POST['email']
		);
		
		$this->user->validate_register($parameters);		
	}
	
	/**
	 *  function displays the edit page
	 *  
	 */
	
	public function action_edit()
	{
		return Response::forge(View::forge('startpage/edit'));
	}
	
	/**
	 *  function which displays forgot password page
	 * 
	 */
	public function action_forgot_password()
	{
		return Response::forge(View::forge('startpage/forgot_password'));
	}
	
	/**
	 *  function which validates reset password
	 *  paremeters: username, email
	 */
	
	public function action_recover()
	{
		$validate = $this->user->validate_recover_password($_POST['username'],$_POST['email']);
		
		if($validate == true)
		{
			$this->user->send_email($_POST['email']);	
		}
		else
		{
			echo "no match";
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
				'file_error'  => $_FILES['picture']['error'],
				'name'	  => $_POST['txtname']		
		);
	
		$this->user->validate_update($parameters);	
	}
	
	/**
	 * 
	 * display the change_password page
	 * 
	 */
	
	public function action_change_password()
	{
		return Response::forge(View::forge('startpage/change_password'), 404);
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
