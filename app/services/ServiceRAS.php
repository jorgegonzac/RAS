<?php
namespace services;
use User;
use Auth;
use Hash;
use Session;
use Ticket;
use DB;
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
		// Check if user has an open ticket in DB
		$user = User::where('username', '=', $username)->get();
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
	 * Private function that allows admin to create tickets for an especific student
	 * @param  [string] $username [username of the user of the ticket]
	 * @param  [string] $place    [place where the user of the ticket will go]
	 * @param  [string] $phone    [phone of the user of the ticket]
	 * @param  [int] $type     [type of ticket. 1:local, 2:foreign, 3:absence, 4:out of time]
	 * @param  [date] $checkIn  [The date when the ticket was created. If no $checkin is passed, NOW() date will be used. FORMAT: YYYY-MM-DD hh:mm:ss]
	 * @return [type]           [description]
	 */
	private function adminCreatesTicket($username, $place, $phone, $type, $checkIn)
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

		// Get user by his username
		$user = User::where('username', '=', $username)->get();
		$ticket -> user_id = $user[0]->id;

		$response = 500;

		// If the checkin variable is null then save the system date
		if(is_null($checkIn))
		{
			$ticket -> check_in = DB::raw('NOW()');
		}
		else
		{
			$ticket -> check_in = $checkIn;
		}

		// save ticket in DB
		$response = $ticket -> save();

		if($response)
		{
			return $responseCode;
		}

		return 500;
	}
}
		
