<?php
use services\ServiceRASInterface;

class SessionsController extends \BaseController 
{
	// Service instance
	public $serviceRAS;

	/**
	 * Inject an instance of the serviceRasInterface into the controller
	 * @param ServiciceRASInterface $serviceRAS [instance of the service]
	 */
    public function __construct(ServiceRASInterface $serviceRAS)
     {
        $this->serviceRAS = $serviceRAS; 
     }
	
	/**
	 * Show the form to login.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('login');
	}

	/**
	 * Authenticate user credentials
	 * @return view
	 */
	public function authenticate()
	{
		// validate the info, create rules for the inputs
		$rules = array(
		    'password' => 'required',
			'username' => 'required'
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) 
		{
		    return Redirect::to('login')
		        ->withErrors($validator) // send back all errors to the login form
		        ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		}
		else
		{
			$username = Input::get('username');
			$password = Input::get('password');

			$authCode = $this->serviceRAS->authenticate($username, $password);

			switch ($authCode) {
				case -1:
					// The username doesn't exist
					$errors['username'] = "Username does not exist";
					return Redirect::to('login')
			        ->withErrors($errors);

				case -2:
					// Invalid Password 
					$errors['password'] = "Username and Password do not match";
					return Redirect::to('login')
			        ->withErrors($errors);

				case 1:
					// Student 
					return Redirect::to('student');

				case 2:
					// Resident Assitant
					return Redirect::to('student');

				case 3:
					// Parent
					return Redirect::to('parent');

				case 4:
					// Admin 
					return Redirect::to('admin');

				case 5:
					// Office
					return Redirect::to('office');
									
				default:
					// If none of above, then redirect to login
					$errors['system'] = "Hubo un error en el sistema. Intente de nuevo";
					return Redirect::to('login')
			        ->withErrors($errors);
			}
		}
	}

	/**
	 * Remove the specified session from storage.
	 *
	 * @param  int  $id
	 * @return view
	 */
	public function destroy()
	{
		// Logout from system and destroy session variables
		Session::flush();
		Auth::logout();

		// redirect user to login page
		return Redirect::to('login');
	}
}
