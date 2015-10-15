<?php

class SessionsControllerTest extends TestCase 
{

	/**
	 * Test that an student logins with valid credentials
	 * @return [type] [description]
	 */
	public function testValidCredentialsStudent()
	{
		// Authentication code that will be returned from mocked method
		$expectedAuthCode = -1;

	   	// Create mock service
		$mock = Mockery::mock('Services\ServiceRASInterface');

		// mock the method authenticate and return the expected code
	    $mock->shouldReceive('authenticate')->withAnyArgs()->once()->andReturn($expectedAuthCode);
	 
	 	// inject mock service
	    $this->app->instance('Services\ServiceRASInterface', $mock);

	 	// data credentials
	 	$data['username'] = 'A00567911';
	 	$data['password'] = 'Firulais123*';

	    // Call the authenticate method from controller 
	    $methodResponse = $this->call('POST', 'login', $data);		

	    // Asserts
        $this->assertRedirectedTo('student');
	}

	/**
	 * Test that a parent logins with valid credentials
	 * @return [type] [description]
	 */
	public function testValidCredentialsParent()
	{
		// Authentication code that will be returned from mocked method
		$expectedAuthCode = 3;

	   	// Create mock service
		$mock = Mockery::mock('Services\ServiceRASInterface');

		// mock the method authenticate and return the expected code
	    $mock->shouldReceive('authenticate')->withAnyArgs()->once()->andReturn($expectedAuthCode);
	 
	 	// inject mock service
	    $this->app->instance('Services\ServiceRASInterface', $mock);

	 	// data credentials
	 	$data['username'] = 'parent';
	 	$data['password'] = 'parent';

	    // Call the authenticate method from controller 
	    $methodResponse = $this->call('POST', 'login', $data);		

	    // Asserts
        $this->assertRedirectedTo('parent');
	}

	/**
	 * Test that a coordinator logins with valid credentials
	 * @return [type] [description]
	 */
	public function testValidCredentialsAdmin()
	{
		// Authentication code that will be returned from mocked method
		$expectedAuthCode = 4;

	   	// Create mock service
		$mock = Mockery::mock('Services\ServiceRASInterface');

		// mock the method authenticate and return the expected code
	    $mock->shouldReceive('authenticate')->withAnyArgs()->once()->andReturn($expectedAuthCode);
	 
	 	// inject mock service
	    $this->app->instance('Services\ServiceRASInterface', $mock);

	 	// data credentials
	 	$data['username'] = 'admin';
	 	$data['password'] = 'admin';

	    // Call the authenticate method from controller 
	    $methodResponse = $this->call('POST', 'login', $data);		

	    // Asserts
        $this->assertRedirectedTo('admin');
	}

	/**
	 * Test that a Resident Assitant logins with valid credentials
	 * @return [type] [description]
	 */
	public function testValidCredentialsResidentAsistant()
	{
		// Authentication code that will be returned from mocked method
		$expectedAuthCode = 2;

	   	// Create mock service
		$mock = Mockery::mock('Services\ServiceRASInterface');

		// mock the method authenticate and return the expected code
	    $mock->shouldReceive('authenticate')->withAnyArgs()->once()->andReturn($expectedAuthCode);
	 
	 	// inject mock service
	    $this->app->instance('Services\ServiceRASInterface', $mock);

	 	// data credentials
	 	$data['username'] = 'A00567911';
	 	$data['password'] = 'Firulais123*';

	    // Call the authenticate method from controller 
	    $methodResponse = $this->call('POST', 'login', $data);		

	    // Asserts
        $this->assertRedirectedTo('student');
	}

	/**
	 * Test that the user does not exist
	 * @return [type] [description]
	 */
	public function testUserDoesntExist()
	{
		// Authentication code that will be returned from mocked method
		$expectedAuthCode = -1;

	   	// Create mock service
		$mock = Mockery::mock('Services\ServiceRASInterface');

		// mock the method authenticate and return the expected code
	    $mock->shouldReceive('authenticate')->withAnyArgs()->once()->andReturn($expectedAuthCode);
	 
	 	// inject mock service
	    $this->app->instance('Services\ServiceRASInterface', $mock);

	 	// data credentials
	 	$data['username'] = 'user';
	 	$data['password'] = 'password';

	    // Call the authenticate method from controller 
	    $methodResponse = $this->call('POST', 'login', $data);		

	    // Asserts
        $this->assertRedirectedTo('login');
	}

	/**
	 * Test that the password is not valid
	 * @return [type] [description]
	 */
	public function testInvalidPassword()
	{
		// Authentication code that will be returned from mocked method
		$expectedAuthCode = -2;

	   	// Create mock service
		$mock = Mockery::mock('Services\ServiceRASInterface');

		// mock the method authenticate and return the expected code
	    $mock->shouldReceive('authenticate')->withAnyArgs()->once()->andReturn($expectedAuthCode);
	 
	 	// inject mock service
	    $this->app->instance('Services\ServiceRASInterface', $mock);

	 	// data credentials
	 	$data['username'] = 'A00567911';
	 	$data['password'] = 'password';

	    // Call the authenticate method from controller 
	    $methodResponse = $this->call('POST', 'login', $data);		

	    // Asserts
        $this->assertRedirectedTo('login');
	}

	/**
	 * Test that the user is an student but not a resident
	 * @return [type] [description]
	 */
	public function testUserIsStudentButNotResident()
	{
		// Authentication code that will be returned from mocked method
		$expectedAuthCode = -1;

	   	// Create mock service
		$mock = Mockery::mock('Services\ServiceRASInterface');

		// mock the method authenticate and return the expected code
	    $mock->shouldReceive('authenticate')->withAnyArgs()->once()->andReturn($expectedAuthCode);
	 
	 	// inject mock service
	    $this->app->instance('Services\ServiceRASInterface', $mock);

	 	// data credentials
	 	$data['username'] = 'A01205500';
	 	$data['password'] = 'password';

	    // Call the authenticate method from controller 
	    $methodResponse = $this->call('POST', 'login', $data);		

	    // Asserts
        $this->assertRedirectedTo('login');
	}

	/**
	 * Test that the password was not provided
	 * @return [type] [description]
	 */
	public function testNoPasswordProvided()
	{
		// Authentication code that will be returned from mocked method
		$expectedAuthCode = -2;

	   	// Create mock service
		$mock = Mockery::mock('Services\ServiceRASInterface');

		// mock the method authenticate and return the expected code
	    $mock->shouldReceive('authenticate')->withAnyArgs()->once()->andReturn($expectedAuthCode);
	 
	 	// inject mock service
	    $this->app->instance('Services\ServiceRASInterface', $mock);

	 	// data credentials
	 	$data['username'] = 'A00567911';

	    // Call the authenticate method from controller 
	    $methodResponse = $this->call('POST', 'login', $data);		

	    // Asserts
        $this->assertRedirectedTo('login');
	}

	/**
	 * Test that the user id was not provided
	 * @return [type] [description]
	 */
	public function testNoUserIDProvided()
	{
		// Authentication code that will be returned from mocked method
		$expectedAuthCode = -2;

	   	// Create mock service
		$mock = Mockery::mock('Services\ServiceRASInterface');

		// mock the method authenticate and return the expected code
	    $mock->shouldReceive('authenticate')->withAnyArgs()->once()->andReturn($expectedAuthCode);
	 
	 	// inject mock service
	    $this->app->instance('Services\ServiceRASInterface', $mock);

	 	// data credentials
	 	$data['password'] = 'password';

	    // Call the authenticate method from controller 
	    $methodResponse = $this->call('POST', 'login', $data);		

	    // Asserts
        $this->assertRedirectedTo('login');
	}
}
