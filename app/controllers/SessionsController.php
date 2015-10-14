<?php
use services\ServiceRASInterface;

class SessionsController extends \BaseController 
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
	 * Show the form to login.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make('login');
	}

	/**
	 * Authenticate user credentials
	 * @return [Response]
	 */
	public function authenticate()
	{
		// validate the info, create rules for the inputs
		$rules = array(
		    'password' => 'required',
			'username' => 'required'
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) 
		{
		    return Redirect::to('login')
		        ->withErrors($validator) // send back all errors to the login form
		        ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		}
		else
		{
			$username = Input::get('username');
			$password = Input::get('password');

			$authCode = $this->serviceRAS->authenticate($username, $password);

			switch ($authCode) {
				case -1:
					// The username doesn't exist
					$errors = "El usuario no existe";
					return Redirect::to('login')
			        ->withErrors($errors);

				case -2:
					// Invalid Password 
					$errors = "La contraseña no coincide";
					return Redirect::to('login')
			        ->withErrors($errors);

				case 1:
					// Student 
					return Redirect::to('student');

				case 2:
					// Resident Assitant
					return Redirect::to('student');

				case 3:
					// Parent
					return Redirect::to('parent');

				case 4:
					// Admin 
					return Redirect::to('admin');
									
				default:
					// If none, then redirect to login
					$errors = "Hubo un error en el sistema. Intente de nuevo";
					return Redirect::to('login')
			        ->withErrors($errors);
			}
		}
	}

	/**
	 * Store a newly created session in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Remove the specified session from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * [auth_pop3_ssl description]
	 * @param  [type] $username  [description]
	 * @param  [type] $password  [description]
	 * @param  [type] $popserver [description]
	 * @return [type]            [description]
	 */
    function auth_pop3_ssl($username, $password, $popserver) {
     
        $isSSL = 0;

        if (substr($popserver, 0, 6) == "ssl://") {
            $isSSL = 1;
        }

        if (trim($username) == '') {
            return false;
        } else {
        
                $fp = fsockopen("$popserver", 110, $errno, $errstr);
        
            if (!$fp) {
                // failed to open POP3
                return false;
            } else {
                //set_socket_blocking($fp, -1); // Turn off blocking

                /*
                  Clear the POP server's Banner Text.
                  eg.. '+OK Welcome to etc etc'
                 */

                $trash = fgets($fp, 128); // Trash to hold the banner
                fwrite($fp, "USER $username\r\n"); // POP3 USER CMD
                $user = fgets($fp, 128);
               	$pos = strpos($user, "+OK");
                
				if($pos === false){
					$auth = false;
				}else{
					fwrite($fp, "PASS $password\r\n"); // POP3 PASS CMD
                    $pass = fgets($fp, 128);
                    
					$pos2 = strpos($pass, "+OK");
					if($pos2 === false){
						$auth = false;
					}else{
						$auth = true;
					}					
				}
				

                fwrite($fp, "QUIT\r\n");
                fclose($fp);
                
                return $auth;
            }
        }
    }

}
