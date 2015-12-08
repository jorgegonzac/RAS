<?php
use services\ServiceRASInterface;

class OfficeController extends \BaseController 
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
	 * Show attendance list
	 *
	 * @return View
	 */
	public function home()
	{
		// Check for user authorization (Office)
		if(Session::get('role')==5)
		{			
			$finalList;

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
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');			
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
