<?php
use services\ServiceRASInterface;

class AdminsController extends \BaseController 
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
		if(Session::get('role')==4)
		{
			return View::make('admin.index');			
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}		
	}

	/**
	 * Display parents
	 *
	 * @return view
	 */
	public function showParents()
	{
		//
	}

	/**
	 * Display resident assistants
	 *
	 * @return view
	 */
	public function showAssistants()
	{
		//
	}
	/**
	 * Display disciplinary reports
	 *
	 * @return view
	 */
	public function showDReports()
	{
		//
	}

	/**
	 * Display tickets
	 *
	 * @return view
	 */
	public function showTickets()
	{
		//
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
}
