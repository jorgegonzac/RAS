<?php

class SessionsController extends \BaseController {


	/**
	 * Show the form to login.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make('login');
	}

	/**
	 * Authenticate user credentials
	 * @return [Response]
	 */
	public function authenticate(){

	}

	/**
	 * Store a newly created session in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Remove the specified session from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
