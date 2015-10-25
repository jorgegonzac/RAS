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
	 * Display user information
	 *
	 * @return view
	 */
	public function showMyInfo()
	{
		// Check for user authorization
		if(Session::get('role') == 3)
		{
			// Get parent instance
			$parent = Auth::user();

			// Get son instance using user_id
			$son = $this->serviceRAS->getUser($parent->user_id);

			// return view with the tickets
			return View::make('parent.showMyInfo')->with(['parent' => $parent, 'son' => $son]);						
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
		// Check for user authorization
		if(Session::get('role') == 3)
		{
			// Get DReports using son's id
			$dReports = $this->serviceRAS->getDReportsByUserID(Auth::user()->user_id);

			// return view with the tickets
			return View::make('parent.dReports')->with(['dReports' => $dReports]);						
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}			
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
		}
		elseif($response == 412)
		{
			$errors = 'The school id is not registered in the system';
			return Redirect::to('createAccount')
		        ->withErrors($errors) // send back all errors to the  form
		        ->withInput(Input::all());				
		}
		elseif($response == 409)
		{
			$errors = 'That username already exist';
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

	/**
	 * Display a listing of the resident assistants.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Call service and get users by role = parent
			$users = $this->serviceRAS->getUsersByRole('parent');

			// return view with the tickets
			return View::make('admin.users.parents.index')->with(['users' => $users]);						
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}	
	}


	/**
	 * Show the form for creating a new resident assistant.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			return View::make('admin.users.parents.create');						
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}	
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Check for user authorization
		if(Session::get('role') == 4)
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
				'email' => 'required|email',
				'password' => 'required',
				'passwordConfirm' => 'required',
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) 
			{
			    return Redirect::to('parents/create')
			        ->withErrors($validator) // send back all errors to the  form
			        ->withInput(Input::all()); // send back the input so that we can repopulate the form
			}

			// if passwords doesn't match, redirect back to the form
			if($password != $passwordConfirm)
			{
				$errors = 'The passwords doesnt match';

			    return Redirect::to('parents/create')
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

				return Redirect::action('ParentsController@create');	
			}
			elseif($response == 412)
			{
				$errors = 'The school id is not registered in the system';
				return Redirect::to('parents/create')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}
			elseif($response == 409)
			{
				$errors = 'That username already exist';
				return Redirect::to('parents/create')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
		
			// The system had an error
			$errors = 'There was an error';
			return Redirect::to('parents/create')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());		
		}		
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}	
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified parent.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{		
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Call service to get user by his id
			$user = $this->serviceRAS->getUser($id);
			$son = $this->serviceRAS->getUser($user->user_id);

			return View::make('admin.users.parents.edit')->with(['user' => $user, 'son' => $son]);						
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}
	}


	/**
	 * Update the specified parent in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Get form data
			$username = Input::get('username');
			$schoolID = Input::get('schoolID');
			$firstName = Input::get('firstName');
			$lastName = Input::get('lastName');
			$email = Input::get('email');

			// validate the info, create rules for the inputs
			$rules = array(
			    'username' => 'required|max:9',
				'schoolID' => 'required|max:9|regex:/^[A a L l]\d{8}/',
				'firstName' => 'required|max:20',
				'lastName' => 'required|max:20',
				'email' => 'required|email',
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) 
			{
			    return Redirect::to('parents/' . $id .'/edit')
			        ->withErrors($validator) // send back all errors to the  form
			        ->withInput(Input::all()); // send back the input so that we can repopulate the form
			}

			// Call the service to update ticket
			$response = $this->serviceRAS->updateParent($id, $username, $schoolID, $firstName, $lastName, $email);		

			// Return a view with the message
			if($response == 201)
			{
				$success = 'The account was updated';
				Session::flash('success', $success);

				return Redirect::action('ParentsController@edit', ['id' => $id]);	
			}
			elseif($response == 412)
			{
				$errors = 'The school id is not registered in the system';
	
			    return Redirect::to('parents/' . $id .'/edit')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
		
			// The system had an error
			$errors = 'There was an error';

		    return Redirect::to('parents/' . $id .'/edit')
		        ->withErrors($errors) // send back all errors to the  form
		        ->withInput(Input::all());		
		}		
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}	
	}


	/**
	 * Remove the specified assistant from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Call the service to delete user
			$response = $this->serviceRAS->deleteUser($id);

			// Return a view with the message
			if($response == 204)
			{
				$success = 'The parent was deleted';
				Session::flash('success', $success);

				return Redirect::action('ParentsController@index');	
			}
			elseif($response == 404)
			{
				$errors = 'The parent does not exist';
				
				return Redirect::to('parents')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}
		
			// The system had an error
			$errors = 'There was an error';
			
			return Redirect::to('parents')
		        ->withErrors($errors) // send back all errors to the  form
		        ->withInput(Input::all());			
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}			
	}
}
