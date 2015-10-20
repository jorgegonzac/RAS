<?php
use services\ServiceRASInterface;

class TicketsController extends \BaseController 
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
	 * Display a listing of the Absence ticket.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new Absence ticket.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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

			if($response == 200)
			{
				$success = 'The ticket was updated';
				return View::make('student.absenceForm', ['place' => $place, 'phone' => $phone, 'type' => $type, 'success' => $success]);	
			}
			elseif($response == 201)
			{
				$success = 'The ticket was created';
				return View::make('student.absenceForm', ['place' => $place, 'phone' => $phone, 'type' => $type, 'success' => $success]);				
			}elseif($response == 202)
			{
				$success = 'The ticket was created but as -out of time- ';
				return View::make('student.absenceForm', ['place' => $place, 'phone' => $phone, 'type' => 4, 'success' => $success]);				
			}	
		
			// The system had an error
			$errors = 'There was an error';
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
	 * Display the specified Absence ticket.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified Absence ticket.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified Absence ticket in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified Absence ticket from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Shows the attendance list according to role and floor
	 * @return [type] [description]
	 */
	public function showAttendanceList()
	{
		// Check for user authorization (RA+Admin)
		if(Session::get('role')==2 || Session::get('role')==4)
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
			}
			else
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
			}

			return View::make('student.attendance', ['students' => $finalList]);
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');			
		}
	}

	/**
	 * Saves the attendance list into DB
	 * @return [type] [description]
	 */
	public function saveAttendanceList()
	{
		// Check for user authorization (RA+Admin)
		if(Session::get('role')==2 || Session::get('role')==4)
		{			
			$students = Input::get('attendanceList');
			
			// Here the resume of transactions will be saved 
			$created = array();
			$closed = array();
			$problems = array();

			// Check if there are any students selected
			if(is_array($students))
			{
				foreach($students as $key => $username)
				{
					// Data that will be sent to the method
					$place = 'Absence';
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
					elseif($response == 412)
					{
						// There was an open ticket, close it ?					
						$closed[] = $username;
					}
					else
					{
						// There was a system error
						$problems[] = $username;					
					}
				}
			}

			return Redirect::route('takeAttendance')->with(['created' => $created, 'closed' => $closed, 'problems' => $problems]);
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');			
		}
	}
}
