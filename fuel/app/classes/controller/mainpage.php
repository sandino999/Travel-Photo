<?php


class Controller_Mainpage extends Controller
{

	/**
	 * action index for main page
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{	
		$message='';
		return Response::forge(View::forge('startpage/login',array('message'=>$message)));	
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
