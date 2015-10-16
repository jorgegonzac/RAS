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
	 * Display attendance view 
	 *
	 * @return view
	 */
	public function takeAttendance()
	{
		//
	}

	/**
	 * Display absence form 
	 *
	 * @return view
	 */
	public function showAbsenceForm()
	{
		//
	}

}
