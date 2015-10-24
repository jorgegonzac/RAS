<?php
use services\ServiceRASInterface;

class ParentsController extends \BaseController 
{	
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
	 * Display home view.
	 *
	 * @return view
	 */
	public function home()
	{
		// Check for user authorization
		if(Session::get('role') == 3)
		{
			// return index view
			return View::make('parent.index');
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}			
	}


	/**
	 * Display disciplinary reports
	 *
	 * @return view
	 */
	public function showDReports()
	{
	}

	/**
	 * Display son's tickets 
	 *
	 * @return view
	 */
	public function showTickets()
	{		
		// Check for user authorization
		if(Session::get('role') == 3)
		{
			// Get tickets using son's id
			$tickets = $this->serviceRAS->getTicketsByUserID(Auth::user()->user_id);

			// return view with the tickets
			return View::make('parent.tickets')->with(['tickets' => $tickets]);						
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}		
	}

	/**
	 * Show the form for creating a new user.
	 *
	 * @return Response
	 */
	public function createAccount()
	{		
		return View::make('parent.create');		
	}

	/**
	 * store the new parent account.
	 *
	 * @return Response
	 */
	public function storeAccount()
	{		
		// Get form data
		$username = Input::get('username');
		$schoolID = Input::get('schoolID');
		$firstName = Input::get('firstName');
		$lastName = Input::get('lastName');
		$email = Input::get('email');
		$password = Input::get('password');
		$passwordConfirm = Input::get('passwordConfirm');

		// validate the info, create rules for the inputs
		$rules = array(
		    'username' => 'required|max:9',
			'schoolID' => 'required|max:9|regex:/^[A a L l]\d{8}/',
			'firstName' => 'required|max:20',
			'lastName' => 'required|max:20',
			'lastName' => 'required|max:20',
			'email' => 'required|email',
			'password' => 'required',
			'passwordConfirm' => 'required',
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) 
		{
		    return Redirect::to('createAccount')
		        ->withErrors($validator) // send back all errors to the  form
		        ->withInput(Input::all()); // send back the input so that we can repopulate the form
		}

		// if passwords doesn't match, redirect back to the form
		if($password != $passwordConfirm)
		{
			$errors = 'The passwords doesnt match';

		    return Redirect::to('createAccount')
		        ->withErrors($errors) // send back all errors to the  form
		        ->withInput(Input::all()); // send back the input so that we can repopulate the form			
		}

		// Call the service to create ticket
		$response = $this->serviceRAS->createParent($username, $schoolID, $firstName, $lastName, $email, $password);		

		// Return a view with the message
		if($response == 201)
		{
			$success = 'The account was created. An email was sent with information';
			Session::flash('success', $success);

			return Redirect::action('ParentsController@createAccount');	
		}elseif($response == 412)
		{
			$errors = 'The school id is not registered in the system';
			return Redirect::to('createAccount')
		        ->withErrors($errors) // send back all errors to the  form
		        ->withInput(Input::all());				
		}	
	
		// The system had an error
		$errors = 'There was an error';
		return Redirect::to('student')
		        ->withErrors($errors) // send back all errors to the  form
		        ->withInput(Input::all());					
	}
}
