<?php
use services\ServiceRAS;

class ServiceRASTest extends TestCase 
{
	/**
	 * Test that the given credentials belongs to a valid student (resident)
	 * @return [type] [description]
	 */
	public function testAuthenticateStudent()
	{
		$service = new ServiceRAS();
		$username = 'A00567911';
		$password = 'Firulais123*';
		$expected = 1;
		$response = $service->authenticate($username, $password);
		$this->assertEquals($response, $expected);
	}

	/**
	 * Test that the given credentials are valid and belong to an admin
	 * @return [type] [description]
	 */
	public function testAuthenticateAdmin()
	{
		$service = new ServiceRAS();
		$username = 'admin';
		$password = 'admin';
		$expected = 4;
		$response = $service->authenticate($username, $password);
		$this->assertEquals($response, $expected);
	}

	/**
	 * Test that the given credentials are valid and belong to a parent
	 * @return [type] [description]
	 */
	public function testAuthenticateParent()
	{
		$service = new ServiceRAS();
		$username = 'parent';
		$password = 'parent';
		$expected = 3;
		$response = $service->authenticate($username, $password);
		$this->assertEquals($response, $expected);
	}

	/**
	 * Test that the given credentials are valid and belong to a resident asistant
	 * @return [type] [description]
	 */
	public function testAuthenticateResidentAsistant()
	{
		$service = new ServiceRAS();
		$username = 'A00567911';
		$password = 'Firulais123*';
		$expected = 2;
		$response = $service->authenticate($username, $password);
		$this->assertEquals($response, $expected);
	}

	/**
	 * Test when the username doesn't exist
	 * @return [type] [description]
	 */
	public function testUsernameDoesntExist()
	{
		$service = new ServiceRAS();
		$username = 'A11567911';
		$password = 'Firulais123*';
		$expected = -1;
		$response = $service->authenticate($username, $password);
		$this->assertEquals($response, $expected);
	}

	/**
	 * Test when student password is invalid
	 * @return [type] [description]
	 */
	public function testInvalidPasswordStudent()
	{
		$service = new ServiceRAS();
		$username = 'A00567911';
		$password = 'Firulais';
		$expected = -2;
		$response = $service->authenticate($username, $password);
		$this->assertEquals($response, $expected);
	}

	/**
	 * Test when parent/admin password is invalid
	 * @return [type] [description]
	 */
	public function testInvalidPasswordAdminParent()
	{
		$service = new ServiceRAS();
		$username = 'parent';
		$password = 'admin';
		$expected = -2;
		$response = $service->authenticate($username, $password);
		$this->assertEquals($response, $expected);
	}

	/**
	 * Test when user is an student but not a registered resident
	 * @return [type] [description]
	 */
	public function testUserIsStudentButNotResident()
	{
		$service = new ServiceRAS();
		$username = 'A01205500';
		$password = 'admin';
		$expected = -1;
		$response = $service->authenticate($username, $password);
		$this->assertEquals($response, $expected);
	}
}