<?php

class SessionsController extends \BaseController {

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
			'school_id' => 'required|regex:/^[A a L l]\d{8}/'
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
			//authenticate email account using pop ssl
			$school_id = ucfirst(Input::get('school_id')); // ucfirst is used to transform the 'a' in the school_id to capitalize 
			$password = Input::get('password');
			$popserver = 'pop.itesm.mx';
			$auth = $this->auth_pop3_ssl($school_id, $password, $popserver);

			if($auth)
			{
				return 'AUTHENTICATED';
			}
			else
			{
				return 'ERROR';
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
