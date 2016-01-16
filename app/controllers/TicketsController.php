<?php
use services\ServiceRASInterface;

class TicketsController extends \BaseController 
{
	// service instance
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
	 * Display a listing of the Absence ticket.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Check for user authorization
		if(Session::get('role')==4)
		{
			// Call service and get the tickets
			$tickets = $this->serviceRAS->getTickets();

			return View::make('admin.tickets.index')->with('tickets', $tickets);			
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}			
	}


	/**
	 * Show the form for creating a new Absence ticket.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Check for user authorization
		if(Session::get('role')==4)
		{
			return View::make('admin.tickets.create');			
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}	
	}


	/**
	 * Store a newly created Absence ticket in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Check for user authorization
		if(Session::get('role')==1 || Session::get('role')==2)
		{
			// Get form data
			$place = Input::get('place');
			$phone = Input::get('phone');
			$type = Input::get('type');

			// Get user from session
			$username = Auth::user()->username;	

			// validate the info, create rules for the inputs
			$rules = array(
			    'place' => 'required|max:50',
				'phone' => 'required|numeric|digits:10',
				'type' => 'required|numeric|between:1,4'
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) 
			{
			    return Redirect::to('student')
			        ->withErrors($validator) // send back all errors to the  form
			        ->withInput(Input::all()); // send back the input so that we can repopulate the form
			}

			// Call the service to create ticket
			$response = $this->serviceRAS->studentCreatesTicket($username, $place, $phone, $type, null);		

			// storing was succesfull
			if($response == 200)
			{
				// redirect to previous route with success msg
				$success = 'El aviso fue modificado correctamente';

				return View::make('student.absenceForm', ['place' => $place, 'phone' => $phone, 'type' => $type, 'success' => $success]);	
			}
			elseif($response == 201)
			{
				// redirect to previous route with success msg
				$success = 'El aviso fue creado correctamente';

				return View::make('student.absenceForm', ['place' => $place, 'phone' => $phone, 'type' => $type, 'success' => $success]);				
			}
			elseif($response == 202)
			{
				// redirect to previous route with error msg
				$success = 'El aviso fue creado correctamente pero está Fuera de horario ';

				return View::make('student.absenceForm', ['place' => $place, 'phone' => $phone, 'type' => 4, 'success' => $success]);				
			}	
		
			// redirect to previous route with error msg
			$errors = 'Hubo un error en el sistema. Intente más tarde';

			return Redirect::to('student')
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
	 * Admin can Store a newly created Absence ticket in storage.
	 *
	 * @return Response
	 */
	public function storeTicket()
	{
		// Check for user authorization
		if(Session::get('role')==4)
		{
			// Get form data
			$username = Input::get('username');
			$place = Input::get('place');
			$phone = Input::get('phone');
			$type = Input::get('type');
			$checkIn = Input::get('check-in');
			$checkOut = Input::get('check-out');

			// validate the info, create rules for the inputs
			$rules = array(
				'username' => 'required|regex:/^[A a L l]\d{8}/',
			    'place' => 'required|max:50',
				'phone' => 'required|numeric|digits:10',
				'type' => 'required|numeric|between:1,4',
				'check-in' => 'required|date_format:Y-m-d H:i:s',
				'check-out' => 'required|date_format:Y-m-d H:i:s'
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) 
			{
			    return Redirect::to('tickets/create')
			        ->withErrors($validator) // send back all errors to the  form
			        ->withInput(Input::all()); // send back the input so that we can repopulate the form
			}

			// Call the service to create ticket
			$response = $this->serviceRAS->adminCreatesTicket($username, $place, $phone, $type, $checkIn, $checkOut);	

			// storing was successfull
			if($response == 201)
			{
				// redirect to previous route with success msg
				$success = 'El aviso fue creado correctamente';
				Session::flash('success', $success);

			    return Redirect::action('TicketsController@create');
			}
			elseif($response == 412)
			{
				// redirect to previous route with error msg
				$errors = 'El usuario no existe en el sistema.';

				return Redirect::to('tickets/create')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
		
			// redirect to previous route with error msg
			$errors = 'Hubo un error en el sistema. Intente más tarde.';

			return Redirect::to('tickets/create')
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
	 * Show the form for editing the specified Absence ticket.
	 *
	 * @param  int  $id tickets id
 	 * @return view 
	 */
	public function edit($id)
	{
		// Check for user authorization
		if(Session::get('role')==4)
		{
			// Call service and get the ticket
			$tickets = $this->serviceRAS->getTicket($id);

			return View::make('admin.tickets.edit')->with('ticket', $tickets);			
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}	
	}


	/**
	 * Update the specified Absence ticket in storage.
	 *
	 * @param  int  $id
	 * @return view
	 */
	public function update($id)
	{
		// Check for user authorization
		if(Session::get('role')==4)
		{
			// Get form data
			$username = Input::get('username');
			$place = Input::get('place');
			$phone = Input::get('phone');
			$type = Input::get('type');
			$checkIn = Input::get('check-in');
			$checkOut = Input::get('check-out');

			// validate the info, create rules for the inputs
			$rules = array(
				'username' => 'required|regex:/^[A a L l]\d{8}/',
			    'place' => 'required|max:50',
				'phone' => 'required|numeric|digits:10',
				'type' => 'required|numeric|between:1,4',
				'check-in' => 'date_format:Y-m-d H:i:s',
				'check-out' => 'date_format:Y-m-d H:i:s'
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) 
			{
			    return Redirect::to('tickets/' . $id . '/edit')
			        ->withErrors($validator) // send back all errors to the  form
			        ->withInput(Input::all()); // send back the input so that we can repopulate the form
			}

			// Call the service to create ticket
			$response = $this->serviceRAS->adminUpdatesTicket($id, $username, $place, $phone, $type, $checkIn, $checkOut);	

			// storing wass succesfull
			if($response == 200)
			{
				// redirect to previous route with success msg
				$success = 'El aviso fue actualizado correctamente';
				Session::flash('success', $success);

			    return Redirect::action('TicketsController@edit', array('id' => $id));
			}
			elseif($response == 412)
			{
				// redirect to previous route with error msg
				$errors = 'El usuario no existe en el sistema';

			    return Redirect::to('tickets/' . $id . '/edit')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
		
			// redirect to previous route with error msg
			$errors = 'Hubo un error en el sistema. Intente más tarde';

			    return Redirect::to('tickets/' . $id . '/edit')
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
	 * Remove the specified Absence ticket from storage.
	 *
	 * @param  int  $id ticket id
	 * @return view
	 */
	public function destroy($id)
	{
		// Check for user authorization (Admin)
		if(Session::get('role')==4)
		{					
			// Call service and get response code
			$response = $this->serviceRAS->deleteTicket($id);

			// deletion was successfull
			if($response == 204)
			{
				// save success msg
				$success = 'El aviso fue eliminado correctamente';
				Session::flash('success', $success);
			}
			elseif($response == 404)
			{
				// save error msg
				$errors = 'El aviso no existe en el sistema';
				Session::flash('errors', $errors);
			}
			else{
				// save error msg
				$errors = 'Hubo un error en el sistema. Intente más tarde';
				Session::flash('errors', $errors);
			}

			// redirect to index function so the method can handle the view
			return Redirect::action('TicketsController@index');
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');			
		}
	}
	/* hot fix */
	public function showAttendanceListAdmin($floor)
	{
		// Check for user authorization (RA+Admin+Office)
		if(Session::get('role')==2 || Session::get('role')==4 || Session::get('role')==5)
		{			
			$finalList;

			// Check if user is admin
			if(Session::get('role')==4)
			{
				// Get the attendance list of each floor
				switch ($floor) {
					case 1:
						$finalList = $this->serviceRAS->getAttendanceList(100);	
						break;
					
					case 2:
						$finalList = $this->serviceRAS->getAttendanceList(200);	
						break;
					
					case 3:
						$finalList = $this->serviceRAS->getAttendanceList(300);	
						break;

					case 4:
						$finalList = $this->serviceRAS->getAttendanceList(400);	
						break;
				}

				// Return admin attendance view
				return View::make('admin.attendance.index', ['students' => $finalList]);				
			}
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');			
		}
	}

	/* hot fix */

	/**
	 * Shows the attendance list according to role and floor
	 * @return [view] [returns a view with a list of students]
	 */
	public function showAttendanceList()
	{
		// Check for user authorization (RA+Admin+Office)
		if(Session::get('role')==2 || Session::get('role')==4 || Session::get('role')==5)
		{			
			$finalList;

			// Check if user is admin
			if(Session::get('role')==4)
			{
				// Get the attendance list of each floor
				$listFloor1 = $this->serviceRAS->getAttendanceList(100);	
				$listFloor2 = $this->serviceRAS->getAttendanceList(200);	
				$listFloor3 = $this->serviceRAS->getAttendanceList(300);	
				$listFloor4 = $this->serviceRAS->getAttendanceList(400);	

				// Merge all the lists into a final list
				$finalList = array_merge($listFloor1, $listFloor2, $listFloor3, $listFloor4);

				// Return admin attendance view
				return View::make('admin.attendance.index', ['students' => $finalList]);				
			}
			elseif(Session::get('role')==2) // check if user is resident assistant
			{
				// Get user's room
				$userRoom = Auth::user()->room_number;

				// RA is man, get only floor 1 and 2
				// Business Rule: RA's can only take attendance in the floors of their same gender
				if($userRoom < 300)
				{
					$listFloor1 = $this->serviceRAS->getAttendanceList(100);	
					$listFloor2 = $this->serviceRAS->getAttendanceList(200);
					$finalList = array_merge($listFloor1, $listFloor2);	
				}
				else
				{
					$listFloor3 = $this->serviceRAS->getAttendanceList(300);	
					$listFloor4 = $this->serviceRAS->getAttendanceList(400);
					$finalList = array_merge($listFloor3, $listFloor4);	
				}
				
				// return RA view
				return View::make('student.attendance', ['students' => $finalList]);
			}
			elseif(Session::get('role')==5) // check if user is office user
			{
				// Get the attendance list of each floor
				$listFloor1 = $this->serviceRAS->getAttendanceList(100);	
				$listFloor2 = $this->serviceRAS->getAttendanceList(200);	
				$listFloor3 = $this->serviceRAS->getAttendanceList(300);	
				$listFloor4 = $this->serviceRAS->getAttendanceList(400);	

				// Merge all the lists into a final list
				$finalList = array_merge($listFloor1, $listFloor2, $listFloor3, $listFloor4);

				// Return admin attendance view
				return View::make('office.attendance', ['students' => $finalList]);			
			}
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');			
		}
	}

	/**
	 * Saves the attendance list into DB
	 * @return [view] redirects to the showlist view with data that represents the final state of the save process
	 */
	public function saveAttendanceList()
	{
		// Check for user authorization (RA+Admin+Office)
		if(Session::get('role')==2 || Session::get('role')==4 || Session::get('role')==5)
		{			
			$students = Input::get('attendanceList');
			
			// Here the resume of transactions will be saved 
			$created = array();
			$closed = array();
			$problems = array();
			$msg = 'La lista de asistencia fue guardada correctamente';

			// Check if there are any students selected
			if(is_array($students))
			{
				foreach($students as $key => $username)
				{
					// Data that will be sent to the method
					$place = 'Falta';
					$phone = '4421610181'; // This is the phone of the Residence Hall 
					$type = 3;

					// Call method to create absence
					$response = $this->serviceRAS->residentAssistantCreatesTicket($username, $place, $phone, $type);		

					// Check response code
					if($response == 201)
					{
						// Absence was created succesfully
						$created[] = $username;
					}
					elseif($response == 200)
					{
						// There was an open ticket, close it 				
						$closed[] = $username;
					}
					else
					{						
						// There was a system error
						$problems[] = $username;	

						// update msg
						$msg = $msg . 'Ocurrieron algunos problemas:';				
					}
				}
			}

			if(Session::get('role')==4)
			{
				// redirect to previous route with data
				return Redirect::back()->with(['created' => $created, 'closed' => $closed, 'problems' => $problems, 'msg' => $msg]);
			}

			// redirect to previous route with data
			return Redirect::route('takeAttendance')->with(['created' => $created, 'closed' => $closed, 'problems' => $problems, 'msg' => $msg]);
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');			
		}
	}

	/**
	 * Flush the success and delete messages
	 * @return void      Doesn't return data
	 */
	private function flushMessages()
	{
		Session::flush('success');
		Session::flush('errors');
	}
}
