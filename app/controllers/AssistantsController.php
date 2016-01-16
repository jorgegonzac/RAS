<?php
use services\ServiceRASInterface;

class AssistantsController extends \BaseController 
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
	 * Display a listing of the resident assistants.
	 *
	 * @return view
	 */
	public function index()
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Call service and get users by role = resident assistant
			$users = $this->serviceRAS->getUsersByRole('resident assistant');

			// return view with the users
			return View::make('admin.users.assistants.index')->with(['users' => $users]);						
		}
		else
		{
			// Authenticated user does not have authorization to enter, redirect to login
			return Redirect::to('login');
		}	
	}

	/**
	 * Show the form for creating a new resident assistant.
	 *
	 * @return view
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
			// Authenticated user does not have authorization to enter, redirect to login
			return Redirect::to('login');
		}	
	}

	/**
	 * Store a newly created resident assistant in storage.
	 *
	 * @return view
	 */
	public function store()
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Get form data
			$username = Input::get('username');

			// Validate the info, create rules for the inputs
			$rules = array(
				'username' => 'required|max:9|regex:/^[A a L l]\d{8}/',
			);

			// Run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) 
			{
			    return Redirect::to('assistants/create')
			        ->withErrors($validator) // send back all errors to the  form
			        ->withInput(Input::all()); // send back the input so that we can repopulate the form
			}

			// Call the service to store student
			$response = $this->serviceRAS->createAssistant($username);		

			// storing was success
			if($response == 201)
			{
				// redirect to previous route with success msg
				$success = 'El estudiante fue registrado correctamente como prefecto';
				Session::flash('success', $success);

				return Redirect::action('AssistantsController@create');	
			}
			elseif($response == 404)
			{
				// redirect to previous route with error msg
				$errors = 'El estudiante no está registrado en el sistema';

				return Redirect::to('assistants/create')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
			elseif($response == 409)
			{
				// redirect to previous route with error msg
				$errors = 'El estudiante ya está registrado como prefecto';

				return Redirect::to('assistants/create')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	

			// redirect to previous route with error msg
			$errors = 'Hubo un error en el sistema. Intente más tarde';

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
	 * Remove the specified resident assistant from storage.
	 *
	 * @param  int  $id assistant id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Call the service to delete user
			$response = $this->serviceRAS->deleteAssistant($id);

			// Deletion was successfull
			if($response == 204)
			{
				// redirect to previous route with success msg
				$success = 'El prefecto fue eliminado correctamente';
				Session::flash('success', $success);

				return Redirect::action('AssistantsController@index');	
			}
			elseif($response == 404)
			{
				// redirect to previous route with error msg
				$errors = 'El estudiante no está registrado en el sistema';
				
				return Redirect::to('assistants')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}
		
			// redirect to previous route with error msg
			$errors = 'Hubo un error en el sistema. Intente más tarde';
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
