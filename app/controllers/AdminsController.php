<?php

class AdminsController extends \BaseController 
{
	/**
	 * Display home view.
	 *
	 * @return view
	 */
	public function home()
	{
		// Check for user authorization
		if(Session::get('role')==4)
		{
			return View::make('admin.index');			
		}
		else
		{
			// Authenticated user does not have authorization to enter, redirect to login
			return Redirect::to('login');
		}		
	}
}
