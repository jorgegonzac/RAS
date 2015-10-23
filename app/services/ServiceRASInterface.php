<?php
namespace services;

interface ServiceRASInterface 
{  
	public function authenticate($username, $password);
	public function studentCreatesTicket($username, $place, $phone, $type, $checkIn);
	public function getOpenTicket($username);
	public function getAttendanceList($floor);
	public function residentAssistantCreatesTicket($username, $place, $phone, $type);
	public function adminCreatesTicket($username, $place, $phone, $type, $checkIn, $checkOut);
	public function deleteTicket($id);
	public function getTickets();
	public function getTicket($id);
	public function adminUpdatesTicket($id, $username, $place, $phone, $type, $checkIn, $checkOut);
	public function getDReports();
	public function getDReport($id);
	public function createDReport($username, $description, $date);
	public function updateDReport($id, $username, $description, $date);
	public function deleteDReport($id);
}
