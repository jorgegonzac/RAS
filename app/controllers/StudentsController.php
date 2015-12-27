<?php
use services\ServiceRASInterface;

class StudentsController extends \BaseController 
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
		if(Session::get('role')==1 || Session::get('role')==2)
		{
			// Check if there is an open ticket
			$username = Auth::user()->username;
			$openTicket = $this->serviceRAS->getOpenTicket($username);

			// set ticket data to empty
			$place = "";
			$phone = "";
			$type = "";
			$success = "";

			// check if open ticket exists
			if(!is_null($openTicket))
			{
				// Update ticket data
				$place = $openTicket[0]->place;
				$phone = $openTicket[0]->phone;
				$type = $openTicket[0]->type;
			}

			// return view with ticket data
			return View::make('student.absenceForm', ['place' => $place, 'phone' => $phone, 'type' => $type, 'success' => $success]);
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}
	}

	/**
	 * Display account settings 
	 * @return View
	 */
	public function showSettings()
	{
		// Check for user authorization
		if(Session::get('role')==1 || Session::get('role')==2)
		{
			$user = Auth::user();

			return View::make('student.settings', ['user' => $user]);
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}
	}

	/**
	 * Store account settings 
	 * @return View
	 */
	public function storeSettings()
	{
		// Check for user authorization
		if(Session::get('role')==1 || Session::get('role')==2)
		{
			// validate the info, create rules for the inputs
			$rules = array(
			    'email' => 'required|email',
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) 
			{
			    return Redirect::to('settings')
			        ->withErrors($validator) // send back all errors to the  form
			        ->withInput(Input::all()); // send back the input so that we can repopulate the form
			}

			// get data from Input
			$id = Auth::user()->id;
			$email = Input::get('email');
			$password = Input::get('password');
			$passwordConfirmation = Input::get('passwordConfirmation');

			// call service to save settings
			$response = $this->serviceRAS->storeStudentSettings($id, $email, $password, $passwordConfirmation);			
			
			// storing was successfull
			if($response == 200)
			{
				// redirect to previous route with sucess msg
				$success = 'The settings were stored';
				Session::flash('success', $success);

				return Redirect::action('StudentsController@showSettings');	
			}
			elseif($response == 404)
			{
				// redirect to previous route with error msg
				$errors = 'The student does not exist';

				return Redirect::to('settings')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
			elseif($response == 400)
			{
				// redirect to previous route with error msg
				$errors = 'The passwords need to match';

				return Redirect::to('settings')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
		
			// The system had an error
			$errors = 'There was an error';

			return Redirect::to('settings')
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
	 * Display import form
	 *
	 * @return view
	 */
	public function importStudents()
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// return form view
			return View::make('admin.users.students.import');				
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}		
	}

	/**
	 * store the list of students
	 *
	 * @return view
	 */
	public function storeStudents()
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// validate the info, create rules for the inputs
			$rules = array(
			    'file' => 'required'
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) 
			{
			    return Redirect::to('importStudents')
			        ->withErrors($validator) // send back all errors to the  form
			        ->withInput(Input::all()); // send back the input so that we can repopulate the form
			}

			// Get file and file information from input
			$file = Input::file('file');
			$name = Input::file('file')->getClientOriginalName();
			$extension = Input::file('file')->getClientOriginalExtension();

			// if extension is not excel send error
			if($extension != 'xlsx')
			{	
				// redirect to previous route with error msg
				$errors = 'The file is invalid. Only excel files are valid';
				Session::flash('errors', $errors);

			    return Redirect::to('importStudents');
			}

			// set destination path
			$destionationPath = public_path() . '/files/';

			// attemp to save file into destination path
			$success = $file->move($destionationPath, $name);

			// The file was stored
			if($success)
			{		
				// call service to import list
				$response = $this->serviceRAS->importStudents($destionationPath . $name);

				// the import was success
				if($response == 200)
				{
					// redirect to previous route with success msg
					$success = 'The students were added';

					Session::flash('success', $success);
					return Redirect::action('StudentsController@importStudents');						
				}
				elseif($response == 400)
				{
					// redirect to previous route with error msg
					$errors = 'The file does not have the proper format';

					return Redirect::to('importStudents')
					        ->withErrors($errors) // send back all errors to the  form
					        ->withInput(Input::all());										
				}		
			}

			// redirect to previous route with error msg
			$errors = 'There was an error';

			return Redirect::to('importStudents')
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
	 * Display students
	 *
	 * @return view
	 */
	public function index()
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Call service and get users by role = student
			$students = $this->serviceRAS->getUsersByRole('student');

			// Get resident assistant since they are also students
			$assistants = $this->serviceRAS->getUsersByRole('resident assistant');

			// Merge both collections into a final one
			$users = $students->merge($assistants);

			// return view with the users
			return View::make('admin.users.students.index')->with(['users' => $users]);						
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}		
	}

	/**
	 * Show the form for creating students
	 * @return [type] [description]
	 */
	public function create()
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			return View::make('admin.users.students.create');						
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}	
	}

	/**
	 * store the new student
	 * @return [type] [description]
	 */
	public function store()
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Get form data
			$username = Input::get('username');
			$firstName = Input::get('firstName');
			$lastName = Input::get('lastName');
			$career = Input::get('career');
			$roomNumber = Input::get('roomNumber');

			// validate the info, create rules for the inputs
			$rules = array(
				'username' => 'required|max:9|regex:/^[A a L l]\d{8}/',
				'firstName' => 'required|max:20',
				'lastName' => 'required|max:20',
				'career' => 'required|max:4|alpha',
				'roomNumber' => 'required|digits:3',
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) 
			{
			    return Redirect::to('students/create')
			        ->withErrors($validator) // send back all errors to the  form
			        ->withInput(Input::all()); // send back the input so that we can repopulate the form
			}

			// Call the service to create student
			$response = $this->serviceRAS->createStudent($username, $firstName, $lastName, $career, $roomNumber);		

			// storing was successfull
			if($response == 201)
			{
				// redirect to previous route with sucess msg
				$success = 'The student was created';
				Session::flash('success', $success);

				return Redirect::action('StudentsController@create');	
			}
			elseif($response == 412)
			{
				// redirect to previous route with error msg
				$errors = 'The student was already registered';

				return Redirect::to('students/create')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
		
			// The system had an error
			$errors = 'There was an error';

			return Redirect::to('students/create')
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
	 * Show the form for editing students
	 * @return [view] 
	 */
	public function edit($id)
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Call service to get user by his id
			$user = $this->serviceRAS->getUser($id);

			return View::make('admin.users.students.edit')->with('user', $user);						
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}	
	}

	/**
	 * store the updated student
	 * @return [view] 
	 */
	public function update($id)
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Get form data
			$username = Input::get('username');
			$firstName = Input::get('firstName');
			$lastName = Input::get('lastName');
			$career = Input::get('career');
			$roomNumber = Input::get('roomNumber');

			// validate the info, create rules for the inputs
			$rules = array(
				'username' => 'required|max:9|regex:/^[A a L l]\d{8}/',
				'firstName' => 'required|max:20',
				'lastName' => 'required|max:20',
				'career' => 'required|max:4|alpha',
				'roomNumber' => 'required|digits:3',
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) 
			{
			    return Redirect::to('students/' . $id .'/edit')
			        ->withErrors($validator) // send back all errors to the  form
			        ->withInput(Input::all()); // send back the input so that we can repopulate the form
			}

			// Call the service to create student
			$response = $this->serviceRAS->updateStudent($id, $username, $firstName, $lastName, $career, $roomNumber);		

			// updating was successfull
			if($response == 200)
			{
				// redirect to previous route with success msg
				$success = 'The student was updated';
				Session::flash('success', $success);

				return Redirect::action('StudentsController@edit', ['id' => $id]);	
			}
			elseif($response == 404)
			{
				// redirect to previous route with error msg
				$errors = 'The student does not exist';

			    return Redirect::to('students/' . $id .'/edit')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
		
			// redirect to previous route with error msg
			$errors = 'There was an error';

		    return Redirect::to('students/' . $id .'/update')
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
	 * Deletes the student with the given id
	 * @return [view] redirects to student index view
	 */
	public function destroy($id)
	{
		// Check for user authorization
		if(Session::get('role') == 4)
		{
			// Call the service to delete user
			$response = $this->serviceRAS->deleteUser($id);

			// deletion was sucessfull
			if($response == 204)
			{
				// redirect to previous route with successfull msg
				$success = 'The student was deleted';
				Session::flash('success', $success);

				return Redirect::action('StudentsController@index');	
			}
			elseif($response == 404)
			{
				// redirect to previous route with error msg
				$errors = 'The student does not exist';
				
				return Redirect::to('students')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}
			elseif($response == 412)
			{
				// redirect to previous route with error msg
				$errors = 'Student cannot be deleted. First delete his parent';

				return Redirect::to('students')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}		
		
			// redirect to previous route with error msg
			$errors = 'There was an error';

			return Redirect::to('students')
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
