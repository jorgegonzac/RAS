<?php
namespace services;
use User;
use Auth;
use Hash;
use Session;
include("PopService.php");


class ServiceRAS implements ServiceRASInterface
{
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
}
		
