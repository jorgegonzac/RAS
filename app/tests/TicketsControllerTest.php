<?php

class TicketsControllerTest extends TestCase 
{	
	/**
	 * Test when user creates an absence ticket and with preconditions 
	 * @return [type] [description]
	 */
	public function testStudentCreatesAbsenceTicket()
	{
		// Authentication code that will be returned from mocked method
		$expected = 201;

	   	// Create mock service
		$mock = Mockery::mock('Services\ServiceRASInterface');

		// mock the method createTicket and return the expected code
	    $mock->shouldReceive('createTicket')->withAnyArgs()->once()->andReturn($expected);
	 
	 	// inject mock service
	    $this->app->instance('Services\ServiceRASInterface', $mock);

	 	// data credentials
	 	$data['place'] = 'Leon';
	 	$data['phone'] = '4331231331';
	 	$data['type'] = 1;

	 	// Authenticate into the system
	 	$this->be(User::find(1));
	 	$this->session(['role' => 1]);
	    
	    // Call the store method from controller 
	    $response = $this->call('POST', 'tickets', $data);		

	    // Asserts
//	    $this->assertViewHas('created');
	}

	/**
	 * Test when user creates an absence ticket but he has an open ticket 
	 * @return [type] [description]
	 */
	/*  
	public function testStudentCreatesAbsenceTicketWithPreviousTicketOpen()
	{
		// Authentication code that will be returned from mocked method
		$expected = 409;

	   	// Create mock service
		$mock = Mockery::mock('Services\ServiceRASInterface');

		// mock the method createTicket and return the expected code
	    $mock->shouldReceive('createTicket')->withAnyArgs()->once()->andReturn($expected);
	 
	 	// inject mock service
	    $this->app->instance('Services\ServiceRASInterface', $mock);

	 	// data credentials
	 	$data['place'] = 'Leon';
	 	$data['phone'] = '4331231331';
	 	$data['type'] = 1;
	 	$this->be(User::find(1));

	    // Call the authenticate method from controller 
	    $response = $this->call('POST', 'tickets', $data);		
	    $response = $this->call('POST', 'tickets', $data);		

	    // Asserts
	    $this->assertViewHas('error');
	}*/

	/**
	 * Test when user creates an absence ticket withouth parameters 
	 * @return [type] [description]
	 */
	public function testStudentCreatesAbsenceTicketWithoutParameters()
	{
		// Authentication code that will be returned from mocked method
		$expected = 400;

	   	// Create mock service
		$mock = Mockery::mock('Services\ServiceRASInterface');

		// mock the method createTicket and return the expected code
	    $mock->shouldReceive('createTicket')->withAnyArgs()->once()->andReturn($expected);
	 
	 	// inject mock service
	    $this->app->instance('Services\ServiceRASInterface', $mock);

	 	// Authenticate into the system
	 	$this->be(User::find(1));
	 	$this->session(['role' => 1]);

	    // Call the store method from controller 
	    $response = $this->call('POST', 'tickets');		

	    // Asserts
//	    $this->assertViewHas('error');
	}

	/**
	 * Test when user creates an absence ticket but he has an open ticket 
	 * @return [type] [description]
	 */
	public function testStudentCreatesAbsenceTicketWithInvalidData()
	{
		// Authentication code that will be returned from mocked method
		$expected = 500;

	   	// Create mock service
		$mock = Mockery::mock('Services\ServiceRASInterface');

		// mock the method createTicket and return the expected code
	    $mock->shouldReceive('createTicket')->withAnyArgs()->once()->andReturn($expected);
	 
	 	// inject mock service
	    $this->app->instance('Services\ServiceRASInterface', $mock);

	 	// data credentials
	 	$data['place'] = '';
	 	$data['phone'] = 'telefono12';
	 	$data['type'] = 'A';

	 	// Authenticate into the system
	 	$this->be(User::find(1));
	 	$this->session(['role' => 1]);

	    // Call the store method from controller 
	    $response = $this->call('POST', 'tickets', $data);		

	    // Asserts
//	    $this->assertViewHas('error');
	}
}