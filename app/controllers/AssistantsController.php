<?php
use services\ServiceRASInterface;

class AssistantsController extends \BaseController 
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
	 * Display a listing of the resident assistants.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Call service and get users by role = resident assistant
			$users = $this->serviceRAS->getUsersByRole('resident assistant');

			// return view with the tickets
			return View::make('admin.users.assistants.index')->with(['users' => $users]);						
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
			return View::make('admin.users.assistants.create');						
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

			// validate the info, create rules for the inputs
			$rules = array(
				'username' => 'required|max:9|regex:/^[A a L l]\d{8}/',
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) 
			{
			    return Redirect::to('assistants/create')
			        ->withErrors($validator) // send back all errors to the  form
			        ->withInput(Input::all()); // send back the input so that we can repopulate the form
			}

			// Call the service to create student
			$response = $this->serviceRAS->createAssistant($username);		

			// Return a view with the message
			if($response == 201)
			{
				$success = 'The student is now a Resident Assistant';
				Session::flash('success', $success);

				return Redirect::action('AssistantsController@create');	
			}
			elseif($response == 404)
			{
				$errors = 'The student is not registered in the system';

				return Redirect::to('assistants/create')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
			elseif($response == 409)
			{
				$errors = 'The student is already a Resident Assistant';

				return Redirect::to('assistants/create')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	

			// The system had an error
			$errors = 'There was an error';

			return Redirect::to('assistants/create')
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
			$response = $this->serviceRAS->deleteAssistant($id);

			// Return a view with the message
			if($response == 204)
			{
				$success = 'The resident assistant was deleted';
				Session::flash('success', $success);

				return Redirect::action('AssistantsController@index');	
			}elseif($response == 404)
			{
				$errors = 'The student does not exist';
				
				return Redirect::to('assistants')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}
		
			// The system had an error
			$errors = 'There was an error';
			return Redirect::to('assistants')
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
