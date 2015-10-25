<?php
namespace services;
use User;
use Auth;
use Hash;
use Session;
use Ticket;
use DB;
use Report;
use Mail;
use Role;
include("PopService.php");


class ServiceRAS implements ServiceRASInterface
{
	/**
	 * Authenticate the given username in the DB, then redirect according to role
	 * @param  [string] $username [username of the user]
	 * @param  [string] $password [password of the user]
	 * @return [int]           [a code that defines the role. -1 if user doesn't exist. -2 incorrect password]
	 */
	public function authenticate($username, $password)
	{
		// Check if username exists in the DB
		$user = User::where('username', '=', $username)->get();

		if(empty($user[0]))
		{
			return -1;
		}

		// Get Rol
		$roles = $user[0]->roles;
		$rol = $roles[0]->id;

		switch ($rol) 
		{
			case 1:
			case 2:
				// Student - Resident Assistant
				
				// Transform to Upper Case first later so it fits the format A00000000				
				$username = ucfirst($username);

				// Connect to itesm pop server and get the authentication
				$popServer = 'pop.itesm.mx';
				$auth = auth_pop3_ssl($username, $password, $popServer);

				if($auth)
				{
					// Authenticate the user into the system
					Auth::login($user[0]);

					// Save user's role in the session
					Session::put('role',$rol);

					return $rol;
				}

				return -2;

				break;
			case 3:
			case 4:
				// Parent - Admin

				if(Auth::attempt(['username' => $username, 'password' => $password]))
				{
					// Authenticate the user into the system
					Auth::login($user[0]);

					// Save user's role in the session
					Session::put('role',$rol);

					return $rol;
				}
				
				return -2;

				break;
			default:
				return -1;
		}
	}

	/**
	 * Get the open ticket (if exists) of the given user
	 * @param  [type] $username [username of the user (must be an student)]
	 * @return [Ticket, null]           [a Ticket type if there was an open ticket, else: null]
	 */
	public function getOpenTicket($username)
	{
		// Check if user exists
		$user = User::where('username', '=', $username)->get();

		// If doesn't exist, return null
		if(empty($user[0]))
		{
			return null;
		}

		// Check if user has an open ticket in DB
		$openTicket = Ticket::where('user_id', '=', $user[0]->id)
							->where('check_out', '=', null)->get();

		// No open tickets where found
		if(empty($openTicket[0]))
		{
			return null;
		}

		return $openTicket;
	}	

	/**
	 * Public function that creates and modifies ticket for students
	 * @param  [string] $username [username of the user of the ticket]
	 * @param  [string] $place    [place where the user of the ticket will go]
	 * @param  [string] $phone    [phone of the user of the ticket]
	 * @param  [int] $type     [type of ticket. 1:local, 2:foreign, 3:absence, 4:out of time]
	 * @param  [date] $checkIn  [The date when the ticket was created. If no $checkin is passed, NOW() date will be used. FORMAT: YYYY-MM-DD hh:mm:ss]
	 * @return [int]           [A response code. 201: created, 200: updated, 500:internal error]
	 */
	public function studentCreatesTicket($username, $place, $phone, $type, $checkIn)
	{
		// Check if ther is an open ticket from this user
		$openTicket = $this->getOpenTicket($username);
		$ticket;

		// Response code
		$responseCode;

		if(is_null($openTicket))
		{
			// If there is no open ticket create a new reference of the ticket
			$ticket = new Ticket();
			$responseCode = 201;
		}
		else
		{
			// If there is no open ticket then get the ticket reference
			$ticket = Ticket::find($openTicket[0] -> id);
			$responseCode = 200;
		}

		// Fill ticket with he given data
		$ticket -> place = $place;
		$ticket -> phone = $phone;
		$ticket -> type = $type;
		$ticket -> check_in = DB::raw('NOW()');

		// Get user by his username
		$user = User::where('username', '=', $username)->get();
		$ticket -> user_id = $user[0]->id;
		
		// Set timezone to Mexico City
		date_default_timezone_set('America/Mexico_City');

		// Get actual hour
		$actualTime = getdate();
		$hours = $actualTime['hours'];

		// Business Rule: Check if time is between 11pm and 6am
		if($hours >= 23 || $hours <6)
		{
			// Set type to 'Out of time'
			$ticket -> type = 4;

			// Set response code to 202 so the controller can send the warning msg
			$responseCode = 202;
		}

		// save ticket in DB
		$response = $ticket -> save();

		// check that there were no errors while saving
		if($response)
		{
			return $responseCode;
		}

		return 500;
	}

	/**
	 * Public function that creates absences tickets 
	 * @param  [string] $username [username of the user of the ticket]
	 * @param  [string] $place    [place where the user of the ticket will go]
	 * @param  [string] $phone    [phone of the user of the ticket]
	 * @param  [int] $type     [type of ticket. 1:local, 2:foreign, 3:absence, 4:out of time]
	 * @return [int]           [A response code. 201: created, 200: updated, 500:internal error]
	 */
	public function residentAssistantCreatesTicket($username, $place, $phone, $type)
	{
		// Check if user has any open ticket
		$openTicket = $this->getOpenTicket($username);

		if(!is_null($openTicket))
		{
			// If there is an open ticket return 412 (precondition failed)
			return 412;
		}

		// Create a new ticket reference
		$ticket = new Ticket();

		// Fill ticket with he given data
		$ticket -> place = $place;
		$ticket -> phone = $phone;
		$ticket -> type = $type;
		$ticket -> check_in = DB::raw('NOW()');

		// Get user by his username
		$user = User::where('username', '=', $username)->get();
		$ticket -> user_id = $user[0]->id;
		
		// Set timezone to Mexico City
		date_default_timezone_set('America/Mexico_City');

		// save ticket in DB
		$response = $ticket -> save();

		// check that there were no errors while saving
		if($response)
		{
			return 201;
		}

		return 500;
	}

	/**
	 * Public function that allows admin to create tickets for an especific student
	 * @param  [string] $username [username of the user of the ticket]
	 * @param  [string] $place    [place where the user of the ticket will go]
	 * @param  [string] $phone    [phone of the user of the ticket]
	 * @param  [int] $type     [type of ticket. 1:local, 2:foreign, 3:absence, 4:out of time]
	 * @param  [date] $checkIn  [The date when the ticket was created. If no $checkin is passed, NOW() date will be used. FORMAT: YYYY-MM-DD hh:mm:ss]
	 * @return [type]           [description]
	 */
	public function adminCreatesTicket($username, $place, $phone, $type, $checkIn, $checkOut)
	{
		// Check if username exists 
		$user = User::where('username', '=', $username)->get();

		// If username doesn't exist, return error 'precondition failed'
		if(empty($user[0]))
		{
			return 412;
		}
		
		// New ticket reference
		$ticket = new Ticket();


		// Fill ticket with he given data
		$ticket -> place = $place;
		$ticket -> phone = $phone;
		$ticket -> type = $type;
		$ticket -> check_in = $checkIn;
		$ticket -> check_out = $checkOut;

		// Get user id and save it on ticket
		$ticket -> user_id = $user[0]->id;

		// save ticket in DB
		$response = $ticket -> save();

		if($response)
		{
			return 201;
		}

		return 500;
	}

	/**
	 * Public function that allows admin to update tickets for an especific student
	 * @param  [int] $id [The id of the ticket]
	 * @param  [string] $username [username of the user of the ticket]
	 * @param  [string] $place    [place where the user of the ticket will go]
	 * @param  [string] $phone    [phone of the user of the ticket]
	 * @param  [int] $type     [type of ticket. 1:local, 2:foreign, 3:absence, 4:out of time]
	 * @param  [date] $checkIn  [The date when the ticket was created. If no $checkin is passed, NOW() date will be used. FORMAT: YYYY-MM-DD hh:mm:ss]
	 * @return [type]           [description]
	 */
	public function adminUpdatesTicket($id, $username, $place, $phone, $type, $checkIn, $checkOut)
	{
		// Check if username exists 
		$user = User::where('username', '=', $username)->get();

		// If username doesn't exist, return error 'precondition failed'
		if(empty($user[0]))
		{
			return 412;
		}
		
		// New ticket reference
		$ticket = Ticket::find($id);
		
		// Check if ticket exist in DB
		if(empty($ticket[0]))
		{
			// Return 'resource not found'
			return 404;
		}

		// Fill ticket with he given data
		$ticket -> place = $place;
		$ticket -> phone = $phone;
		$ticket -> type = $type;

		if(!$checkIn)
		{
			$ticket -> check_in = null;			
		}
		else
		{
			$ticket -> check_in = $checkIn;			
		}
		if(!$checkOut)
		{
			$ticket -> check_out = null;			
		}
		else
		{
			$ticket -> check_out = $checkOut;			
		}

		// Get user id and save it on ticket
		$ticket -> user_id = $user[0]->id;

		// save ticket in DB
		$response = $ticket -> save();

		if($response)
		{
			// Ticket was successfully updated
			return 200;
		}

		return 500;
	}

	/**
	 * gets the attendance list of the given floor. 
	 * @param  [integer] 	 The floor of the wanted list. Values: 100,200,300,400
	 * @return [array]        The list of the given floor
	 */
	public function getAttendanceList($floor)
	{
		// Calculate the next floor
		$nextFloor = $floor + 100;

		// Get the users that live between floor and the next floor
		$users = User::where('room_number', '>=', $floor)
				   	->where('room_number', '<', $nextFloor)->get();
		
		$list = array();

		// for each user, get the important information in order to push it to the list and the return it
		foreach($users as $user)
		{
			// get open ticket if exists
			$openTicket = $this -> getOpenTicket($user -> username);

			// Save only important data from user to send it later
			$userData['name'] = $user -> first_name . " " .$user -> last_name;
			$userData['room_number'] = $user -> room_number;
			$userData['ticket'] = '';
			$userData['username'] = $user -> username;

			// if exists, save open ticket type in user data
			if(!is_null($openTicket))
			{
				$userData['ticket'] = $openTicket[0] -> type;
			}

			// save user data into list
			array_push($list, $userData);
		}

		return $list;
	}

	/**
	 * Deletes ticket with the given id
	 * @param  [int] $id The ticket id
	 * @return [int]     A response code that correspond to the result of deleting the ticket
	 */
	public function deleteTicket($id)
	{
		// Get ticket from id
		$ticket = Ticket::find($id);

		// Check that ticket exist
		if(empty($ticket[0]))
		{
			// return Resource not found
			return 404;
		}

		// Attemp to delete the ticket
		$result = $ticket -> delete();

		// If attemp was success
		if($result)
		{
			// Server successfully processed the request, but is not returning any content
			return 204;
		}

		// there was a system error
		return 500;
	}

	/**
	 * Get user instance by his id
	 * @param  [int] $id Id of the wanted user
	 * @return [User]     An instance to the user
	 */
	public function getUser($id)
	{
		$user = User::find($id);

		return $user;
	}
	
	/**
	 * Get users by role number
	 * @param  [string] $role  The role name of the users to get
	 * @return [array]       An array with the users
	 */
	public function getUsersByRole($role)
	{
		// query users that have the given role
		$users = User::whereHas('roles', function($q) use($role)
		{
    		$q->where('roles.description', $role);
		})->get();


		return $users;
	}

	/**
	 * Get all the tickets
	 * @return [array] An array with all the tickets instances
	 */
	public function getTickets()
	{
		$tickets = Ticket::all();

		return $tickets;
	}

	/**
	 * Get the tickets from a given username
	 * @param  [string] $userID The user's ID of the student (who belongs the tickets)
	 * @return [array]           An array with the associated tickets
	 */
	public function getTicketsByUserID($userID)
	{
		$tickets = Ticket::where('user_id', '=', $userID)->get();

		return $tickets;
	}

	/**
	 * Get the ticket with the given id
	 * @param  [int] $id The ticket id
	 * @return [Ticket]     An instance of the ticket
	 */
	public function getTicket($id)
	{
		$ticket = Ticket::find($id);

		return $ticket;
	}

	/**
	 * Get disciplinary reports
	 * @return [array] [an array with the disciplinary reports]
	 */
	public function getDReports()
	{
		$dReports = Report::all();

		return $dReports;
	}

	/**
	 * Get disciplinary reports using user id
	 * @return [array] [an array with the disciplinary reports]
	 */
	public function getDReportsByUserID($id)
	{
		$dReports = Report::where('user_id', '=', $id)->get();

		return $dReports;
	}

	/**
	 * Creat a disciplinary report with the given data
	 * @param  [string] $username    The username of the student who belongs the report
	 * @param  [string] $description A description of what the studen did and was against the resident hall laws
	 * @param  [date] $date        The date when the DReport was created
	 * @return [int]              A response code that correspond to a final status previously defined
	 */
	public function createDReport($username, $description, $date)
	{
		// Check if username exists 
		$user = User::where('username', '=', $username)->get();

		// If username doesn't exist, return error 'precondition failed'
		if(empty($user[0]))
		{
			return 412;
		}
		
		// New DReport reference
		$report = new Report();

		// Fill DReport with he given data
		$report -> description = $description;
		$report -> date = $date;

		// Get user id and save it on ticket
		$report -> user_id = $user[0]->id;

		// save ticket in DB
		$response = $report -> save();

		if($response)
		{
			// DReport was succesfully created
			return 201;
		}

		// System had an error while processing
		return 500;
	}	

	/**
	 * Creat a disciplinary report with the given data
	 * @param  [int] $id    The id of the dReport to update
	 * @param  [string] $username    The username of the student who belongs the report
	 * @param  [string] $description A description of what the studen did and was against the resident hall laws
	 * @param  [date] $date        The date when the DReport was created
	 * @return [int]              A response code that correspond to a final status previously defined
	 */
	public function updateDReport($id, $username, $description, $date)
	{
		// Check if username exists 
		$user = User::where('username', '=', $username)->get();

		// If username doesn't exist, return error 'precondition failed'
		if(empty($user[0]))
		{
			return 412;
		}
		
		// New DReport reference
		$report = Report::find($id);

		// Fill DReport with he given data
		$report -> description = $description;

		// check if date is null, if yes then set to null
		if(!$date)
		{
			$report -> date = null;			
		}
		else
		{
			$report -> date = $date;			
		}

		// Get user id and save it on ticket
		$report -> user_id = $user[0]->id;

		try
		{
			// save DReport in DB
			$response = $report -> save();
			
			// DReport was succesfully updated
			return 200;
		}
		catch(Exception $e)
		{
			// Something went wrong
			return 500;
		}		
	}	

	/**
	 * Delete the DReport with the given id
	 * @param  [int] $id [the DReport id]
	 * @return [int]     [A final status code of the process]
	 */
	public function deleteDReport($id)
	{
		// Get DReport from id
		$DReport = Report::find($id);

		// Check that DReport exist
		if(empty($DReport))
		{
			// return Resource not found
			return 404;
		}

		try
		{
			// Attemp to delete the DReport
			$result = $DReport -> delete();
			
			// Server successfully processed the request, but is not returning any content
			return 204;
		}
		catch(Exception $e)
		{
			// Something went wrong
			return 500;
		}		
	}	

	/**
	 * Get the dReport with the given id
	 * @param  [int] $id The dReport id
	 * @return [Ticket]     An instance of the dReport
	 */
	public function getDReport($id)
	{
		$dReport = Report::find($id);

		return $dReport;
	}

	/**
	 * Create a parent account with the given data
	 * @param  [string] $username  Parent username
	 * @param  [string] $schoolID  Son's school id
	 * @param  [string] $firstName First name
	 * @param  [string] $lastName  Last name
	 * @param  [string] $email     Parent's Email
	 * @param  [string] $password  Password
	 * @return [int]            Final status code of the process
	 */
	public function createParent($username, $schoolID, $firstName, $lastName, $email, $password)
	{
		// check if schoolID exists
		$son = User::where('username', '=', $schoolID)->get();

		// If schooID doesn't exist, return error 'precondition failed' (son's id need to be registered)
		if(empty($son[0]))
		{
			return 412;
		}		

		// Creat parent instance
		$parent = new User();

		// Fill parent with given data
		$parent -> username = $username; 
		$parent -> first_name = $firstName;
		$parent -> last_name = $lastName;
		$parent -> email = $email;
		$parent -> user_id = $son[0]->id;

		// Encrypt password with hash
		$parent -> password = Hash::make($password);

		// Attemp to save parent into DB
		$result = $parent -> save();

		// Get parent role reference to assign to user
		$role = Role::where('description', '=', 'parent')->get();

		// Associate role to user
		$parent->roles()->attach($role[0]);

		// If attemp was success
		if($result)
		{
			$data = ['username' => $username, 'first_name' => $firstName, 'last_name' => $lastName, 'school_id' => $schoolID];
			// Server successfully created the parent
			Mail::send('emails.confirmation', $data, function($message) use ($email)
			{		
			    $message->from('residenciasqro@gmail.com', 'RAS');

			    $message->to($email)->subject('Your account confirmation');
			});

			// send email confirmation
			return 201;
		}

		// there was a system error
		return 500;
	}

	/**
	 * update a parent account with the given data
	 * @param  [int] $id  Parent's id
	 * @param  [string] $username  Parent username
	 * @param  [string] $schoolID  Son's school id
	 * @param  [string] $firstName First name
	 * @param  [string] $lastName  Last name
	 * @param  [string] $email     Parent's Email
	 * @return [int]            Final status code of the process
	 */
	public function updateParent($id, $username, $schoolID, $firstName, $lastName, $email)
	{
		// check if schoolID exists
		$son = User::where('username', '=', $schoolID)->get();

		// If schooID doesn't exist, return error 'precondition failed' (son's id need to be registered)
		if(empty($son[0]))
		{
			return 412;
		}		

		// Creat parent instance
		$parent = User::find($id);

		// check if parent exists
		if(empty($parent))
		{
			// resource not found
			return 404;
		}

		// Fill parent with given data
		$parent -> username = $username; 
		$parent -> first_name = $firstName;
		$parent -> last_name = $lastName;
		$parent -> email = $email;
		$parent -> user_id = $son[0]->id;

		try
		{
			// Attemp to save parent into DB
			$result = $parent -> save();

			// success
			return 201;
		}
		catch(Exception $e)
		{
			// Something went wrong
			return 500;
		}	
	}

	/**
	 * Creates a new student
	 * @param  [string] $username   Student username
	 * @param  [string] $firstName  Student first name
	 * @param  [string] $lastName   Student last name
	 * @param  [string] $career     Student career
	 * @param  [int] $roomNumber Student room number
	 * @return [int]             A status code of the final state of the process
	 */
	public function createStudent($username, $firstName, $lastName, $career, $roomNumber)
	{
		// Check that user doesn't exist in DB
		$userExist = User::where('username', '=', $username)->get();
		
		if(!empty($userExist[0]))
		{
			// precondition failed, user exists
			return 412;
		}

		// Create student instance
		$user = new User();

		// Fill student with given data
		$user -> username = $username; 
		$user -> first_name = $firstName;
		$user -> last_name = $lastName;
		$user -> career = $career;
		$user -> room_number = $roomNumber;

		// Get student role reference to assign to user
		$role = Role::where('description', '=', 'student')->get();

		try
		{
			// Attemp to save user into DB
			$result = $user -> save();

			// Associate role to user
			$user->roles()->attach($role[0]);
			
			// success
			return 201;
		}
		catch(Exception $e)
		{
			// Something went wrong
			return 500;
		}		
	}

	/**
	 * Creat a resident assistat using the given username
	 * @param  [string] $username The username of the student (who will upgrade his role)
	 * @return [int]           An status code
	 */
	public function createAssistant($username)
	{
		// Check that user exist in DB
		$user = User::where('username', '=', $username)->get();
		
		if(empty($user[0]))
		{
			// precondition failed, user must be registered in the system
			return 412;
		}

		// Get resident assistant role reference to assign to user
		$role = Role::where('description', '=', 'resident assistant')->get();

		try
		{
			// Associate role to user
			$user[0]->roles()->attach($role[0]);
			
			// succesfull
			return 201;
		}
		catch(Exception $e)
		{
			// Something went wrong
			return 500;
		}	
	}
	
	/**
	 * Creates a new student
	 * @param  [int] $id   Student's id
	 * @param  [string] $username   Student username
	 * @param  [string] $firstName  Student first name
	 * @param  [string] $lastName   Student last name
	 * @param  [string] $career     Student career
	 * @param  [int] $roomNumber Student room number
	 * @return [int]             A status code of the final state of the process
	 */
	public function updateStudent($id, $username, $firstName, $lastName, $career, $roomNumber)
	{
		// Check that user doesn't exist in DB
		$user = User::find($id);

		if(!empty($user[0]))
		{
			// resource not found
			return 404;
		}

		// Fill student with given data
		$user -> username = $username; 
		$user -> first_name = $firstName;
		$user -> last_name = $lastName;
		$user -> career = $career;
		$user -> room_number = $roomNumber;

		try
		{
			// Attemp to save user into DB
			$result = $user -> save();
	
			// send code success
			return 200;
		}
		catch(Exception $e)
		{
			// Something went wrong
			return 500;
		}	
	}

	/**
	 * Deletes user with the given id
	 * @param  [int] $id the user id
	 * @return [int]     A final status code of the deletion process
	 */
	public function deleteUser($id)
	{
		$user = User::find($id);

		// check if user exists
		if(empty($user))
		{
			// if not, return 404, resource not found
			return 404;
		}

		try
		{
			// Attemp to delete
			$result = $user -> delete();
	
			// Return success code if deletion was succesfull
			return 204;
		}
		catch(Exception $e)
		{
			// Something went wrong
			return 500;
		}	
	}

	/**
	 * Deletes resident assistant with the given id
	 * @param  [int] $id the user id
	 * @return [int]     A final status code of the deletion process
	 */
	public function deleteAssistant($id)
	{
		$user = User::find($id);

		// check if user exists
		if(empty($user))
		{
			// if not, return 404, resource not found
			return 404;
		}

		// Get resident assistant role reference 
		$role = Role::where('description', '=', 'resident assistant')->get();

		try
		{
			// Attemp to delete RA role
			$user->roles()->detach($role[0]->id);
	
			// Return success code if deletion was succesfull
			return 204;
		}
		catch(Exception $e)
		{
			// Something went wrong
			return 500;
		}		
	}
}
		
