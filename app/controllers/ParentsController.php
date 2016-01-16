<?php
use services\ServiceRASInterface;

class ParentsController extends \BaseController 
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

		// Passwords doesn't match
		if($password != $passwordConfirm)
		{
			// redirect to previous route with error msg
			$errors = 'Las contraseñas no coinciden. Verifique de nuevo';

		    return Redirect::to('createAccount')
		        ->withErrors($errors) // send back all errors to the  form
		        ->withInput(Input::all()); // send back the input so that we can repopulate the form			
		}

		// Call the service to create ticket
		$response = $this->serviceRAS->createParent($username, $schoolID, $firstName, $lastName, $email, $password);		

		// storing was successfull
		if($response == 201)
		{
			// redirect to previous route with success msg
			$success = 'La cuenta fue creada exitosamente. Se envió un correo de confirmación con sus datos';
			Session::flash('success', $success);

			return Redirect::action('ParentsController@createAccount');	
		}
		elseif($response == 412)
		{
			// redirect to previous route with error msg
			$errors = 'La matrícula ingresada no está registrada en el sistema';

			return Redirect::to('createAccount')
		        ->withErrors($errors) // send back all errors to the  form
		        ->withInput(Input::all());				
		}
		elseif($response == 409)
		{
			// redirect to previous route with error msg
			$errors = 'El usuario ingresado ya existe en el sistema, intente otro';

			return Redirect::to('createAccount')
		        ->withErrors($errors) // send back all errors to the  form
		        ->withInput(Input::all());				
		}	
	
		// redirect to previous route with error msg
		$errors = 'Hubo un error en el sistema. Intente más tarde';

		return Redirect::to('student')
		        ->withErrors($errors) // send back all errors to the  form
		        ->withInput(Input::all());					
	}

	/**
	 * Display a listing of the parents.
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
	 * Show the form for creating a new parent.
	 *
	 * @return view
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
	 * Store a newly created parent in storage.
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

			// passwords doesn't match
			if($password != $passwordConfirm)
			{
				// redirect to previous route with error msg
				$errors = 'Las contraseñas no coinciden. Verifique de nuevo';

			    return Redirect::to('parents/create')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all()); // send back the input so that we can repopulate the form			
			}

			// Call the service to create ticket
			$response = $this->serviceRAS->createParent($username, $schoolID, $firstName, $lastName, $email, $password);		

			// storing was successfull
			if($response == 201)
			{
				// redirect to previous route with success msg
				$success = 'La cuenta fue creada exitosamente. Se envió un correo de confirmación con sus datos';
				Session::flash('success', $success);

				return Redirect::action('ParentsController@create');	
			}
			elseif($response == 412)
			{
				// redirect to previous route with error msg
				$errors = 'La matrícula ingresada no está registrada en el sistema';

				return Redirect::to('parents/create')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}
			elseif($response == 409)
			{
				// redirect to previous route with error msg
				$errors = 'El usuario ingresado ya existe en el sistema, intente otro';

				return Redirect::to('parents/create')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
		
			// redirect to previous route with error msg
			$errors = 'Hubo un error en el sistema. Intente más tarde';
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
	 * Show the form for editing the specified parent.
	 *
	 * @param  int  $id parents id
	 * @return view
	 */
	public function edit($id)
	{		
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Call service to get parent by his id
			$user = $this->serviceRAS->getUser($id);

			// Call service to get parent's son by his id
			$son = $this->serviceRAS->getUser($user->user_id);

			// return view with parent and son data
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
	 * @param  int  $id parent id
	 * @return view
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

			// udpating was successfull
			if($response == 201)
			{
				// redirect to previous route with success msg
				$success = 'La información de la cuenta fue modificada correctamente';
				Session::flash('success', $success);

				return Redirect::action('ParentsController@edit', ['id' => $id]);	
			}
			elseif($response == 412)
			{
				// redirect to previous route with error msg
				$errors = 'La matrícula ingresada no está registrada en el sistema';
	
			    return Redirect::to('parents/' . $id .'/edit')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
		
			// redirect to previous route with error msg
			$errors = 'Hubo un error en el sistema. Intente más tarde';

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
	 * @param  int  $id parent id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Call the service to delete user
			$response = $this->serviceRAS->deleteUser($id);

			// deletion was successfull
			if($response == 204)
			{
				// redirect to previous route with success msg
				$success = 'La cuenta fue eliminada correctamente';
				Session::flash('success', $success);

				return Redirect::action('ParentsController@index');	
			}
			elseif($response == 404)
			{
				// redirect to previous route with error msg
				$errors = 'La cuenta seleccionada no existe';
				
				return Redirect::to('parents')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}
		
			// redirect to previous route with error msg
			$errors = 'Hubo un error en el sistema. Intente más tarde';
			
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