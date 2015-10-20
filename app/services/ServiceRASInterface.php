<?php
namespace services;

interface ServiceRASInterface 
{  
	public function authenticate($username, $password);
	public function studentCreatesTicket($username, $place, $phone, $type, $checkIn);
	public function getOpenTicket($username);
	public function getAttendanceList($floor);
	public function residentAssistantCreatesTicket($username, $place, $phone, $type);
}
