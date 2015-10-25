<?php
use services\ServiceRASInterface;

class StudentsController extends \BaseController 
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
		if(Session::get('role')==1 || Session::get('role')==2)
		{
			// Check if there is an open ticket
			$username = Auth::user()->username;
			$openTicket = $this->serviceRAS->getOpenTicket($username);

			$place = "";
			$phone = "";
			$type = "";
			$success = "";

			if(!is_null($openTicket))
			{
				// Update variables
				$place = $openTicket[0]->place;
				$phone = $openTicket[0]->phone;
				$type = $openTicket[0]->type;
			}

			return View::make('student.absenceForm', ['place' => $place, 'phone' => $phone, 'type' => $type, 'success' => $success]);
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

			// Save file into system
			$file = Input::file('file');
			$name = Input::file('file')->getClientOriginalName();
			$destionationPath = public_path() . '/files/';
			$success = $file->move($destionationPath, $name);

			// The file was stored
			if($success)
			{		
				// call service to import list
				$response = $this->serviceRAS->importStudents($destionationPath . $name);

				// If the import was success, return to view with success msg
				if($response == 200)
				{
					$success = 'The students were added';

					Session::flash('success', $success);
					return Redirect::action('StudentsController@importStudents');						
				}		
			}

			// The system had an error
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
			$users = $this->serviceRAS->getUsersByRole('student');

			// return view with the tickets
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

			// Return a view with the message
			if($response == 201)
			{
				$success = 'The student was created';
				Session::flash('success', $success);

				return Redirect::action('StudentsController@create');	
			}
			elseif($response == 412)
			{
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
	 * @return [type] [description]
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
	 * @return [type] [description]
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

			// Return a view with the message
			if($response == 200)
			{
				$success = 'The student was updated';
				Session::flash('success', $success);

				return Redirect::action('StudentsController@edit', ['id' => $id]);	
			}
			elseif($response == 404)
			{
				$errors = 'The student does not exist';

			    return Redirect::to('students/' . $id .'/edit')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
		
			// The system had an error
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

			// Return a view with the message
			if($response == 204)
			{
				$success = 'The student was deleted';
				Session::flash('success', $success);

				return Redirect::action('StudentsController@index');	
			}elseif($response == 404)
			{
				$errors = 'The student does not exist';
				
				return Redirect::to('students')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}elseif($response == 412)
			{
				$errors = 'Student cannot be deleted. First delete his parent';
				return Redirect::to('students')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}		
		
			// The system had an error
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
