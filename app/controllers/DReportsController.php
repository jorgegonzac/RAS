<?php
use services\ServiceRASInterface;

class DReportsController extends \BaseController 
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
	 * Display a listing of the Disciplinary Report.
	 *
	 * @return view
	 */
	public function index()
	{
		// Check for user authorization
		if(Session::get('role')==4)
		{
			// Call service and get the dReports
			$dReports = $this->serviceRAS->getDReports();

			// return view with data
			return View::make('admin.dReports.index')->with('dReports', $dReports);			
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}		
	}

	/**
	 * Show the form for creating a new Disciplinary Report.
	 *
	 * @return view
	 */
	public function create()
	{
		// Check for user authorization
		if(Session::get('role')==4)
		{
			// return form
			return View::make('admin.dReports.create');			
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}	
	}

	/**
	 * Store a newly created Disciplinary Report in storage.
	 *
	 * @return view
	 */
	public function store()
	{
		// Check for user authorization
		if(Session::get('role')==4)
		{
			// Get form data
			$username = Input::get('username');
			$description = Input::get('description');
			$date = Input::get('date');

			// validate the info, create rules for the inputs
			$rules = array(
				'username' => 'required|regex:/^[A a L l]\d{8}/',
			    'description' => 'required|max:300',
				'date' => 'required|date_format:Y-m-d H:i:s'
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) 
			{
			    return Redirect::to('dReports/create')
			        ->withErrors($validator) // send back all errors to the  form
			        ->withInput(Input::all()); // send back the input so that we can repopulate the form
			}

			// Call the service to create dReport
			$response = $this->serviceRAS->createDReport($username, $description, $date);	

			// storing was succesfull
			if($response == 201)
			{
				// redirect to previous route with success msg
				$success = 'Se creó correctamente el reporte disciplinario';
				Session::flash('success', $success);

			    return Redirect::action('DReportsController@create');
			}
			elseif($response == 412)
			{
				// redirect to previous route with error msg
				$errors = 'El estudiante no está registrado en el sistema';

				return Redirect::to('dReports/create')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
		
			// redirect to previous route with error msg
			$errors = 'Hubo un error en el sistema. Intente más tarde';

			return Redirect::to('dReports/create')
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
	 * Show the form for editing the specified Disciplinary Report.
	 *
	 * @param  [int]  $id disciplinary report id
	 * @return [view]
	 */
	public function edit($id)
	{
		// Check for user authorization
		if(Session::get('role')==4)
		{
			// Call service and get the dReport
			$dReport = $this->serviceRAS->getDReport($id);

			return View::make('admin.dReports.edit')->with('dReport', $dReport);			
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');
		}	
	}

	/**
	 * Update the specified Disciplinary Report in storage.
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
			$description = Input::get('description');
			$date = Input::get('date');

			// validate the info, create rules for the inputs
			$rules = array(
				'username' => 'required|regex:/^[A a L l]\d{8}/',
			    'description' => 'required|max:300',
				'date' => 'required|date_format:Y-m-d H:i:s'
			);

			// run the validation rules on the inputs from the form
			$validator = Validator::make(Input::all(), $rules);

			// if the validator fails, redirect back to the form
			if ($validator->fails()) 
			{
			    return Redirect::to('dReports/' . $id . '/edit')
			        ->withErrors($validator) // send back all errors to the  form
			        ->withInput(Input::all()); // send back the input so that we can repopulate the form
			}

			// Call the service to create dReport
			$response = $this->serviceRAS->updateDReport($id, $username, $description, $date);	

			// update was successfull
			if($response == 200)
			{
				// redirect to previous route with success msg
				$success = 'Se modificó correctamente el reporte disciplinario';
				Session::flash('success', $success);

			    return Redirect::action('DReportsController@edit', array('id' => $id));
			}
			elseif($response == 412)
			{
				// redirect to previous route with error msg
				$errors = 'El estudiante no está registrado en el sistema.';

			    return Redirect::to('dReports/' . $id . '/edit')
			        ->withErrors($errors) // send back all errors to the  form
			        ->withInput(Input::all());				
			}	
		
			// redirect to previous route with error msg
			$errors = 'Hubo un error en el sistema. Intente más tarde';

		    return Redirect::to('dReports/' . $id . '/edit')
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
	 * Remove the specified Disciplinary Report from storage.
	 *
	 * @param  [int]  $id disciplinary report id
	 * @return view
	 */
	public function destroy($id)
	{
		// Check for user authorization (Admin)
		if(Session::get('role')==4)
		{					
			// Call service and get response code
			$response = $this->serviceRAS->deleteDReport($id);

			// deleting was success
			if($response == 204)
			{
				// save success msg in session
				$success = 'El reporte disciplinario fue borrado exitosamente';
				Session::flash('success', $success);
			}
			elseif($response == 404)
			{
				// save error msg in session
				$errors = 'El reporte disciplinario seleccionado no existe';
				Session::flash('errors', $errors);
			}
			else{
				// save error msg in session
				$errors = 'Hubo un error en el sistema. Intente más tarde';
				Session::flash('errors', $errors);
			}

			// redirect to index function so the method can handle the view
			return Redirect::action('DReportsController@index');
		}
		else
		{
			// Authenticated user does not have authorization to enter
			return Redirect::to('login');			
		}
	}
}