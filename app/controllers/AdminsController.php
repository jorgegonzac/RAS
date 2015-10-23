<?php

class AdminsController extends \BaseController {

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
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}		
	}

	/**
	 * Display users
	 *
	 * @return view
	 */
	public function showUsers()
	{
		//
	}

	/**
	 * Display disciplinary reports
	 *
	 * @return view
	 */
	public function showDReports()
	{
		//
	}

	/**
	 * Display tickets
	 *
	 * @return view
	 */
	public function showTickets()
	{
		//
	}

	/**
	 * Display attendance view 
	 *
	 * @return view
	 */
	public function takeAttendance()
	{
		//
	}
}
