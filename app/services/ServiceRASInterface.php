<?php
namespace services;

interface ServiceRASInterface 
{  
	// Authentication methods
	public function authenticate($username, $password);

	// Tickets methods
	public function getAttendanceList($floor);
	public function studentCreatesTicket($username, $place, $phone, $type, $checkIn);
	public function getOpenTicket($username);
	public function residentAssistantCreatesTicket($username, $place, $phone, $type);
	public function adminCreatesTicket($username, $place, $phone, $type, $checkIn, $checkOut);
	public function deleteTicket($id);
	public function getTickets();
	public function getTicket($id);
	public function getTicketsByUserID($userID);	
	public function adminUpdatesTicket($id, $username, $place, $phone, $type, $checkIn, $checkOut);
	public function closeTicket($id);

	// User methods
	public function getUser($id);
	public function getUsersByRole($role);
	public function deleteUser($id);	

	// Disciplinary report methods
	public function getDReports();
	public function getDReport($id);
	public function getDReportsByUserID($id);
	public function createDReport($username, $description, $date);
	public function updateDReport($id, $username, $description, $date);
	public function deleteDReport($id);

	// Parent methods
	public function createParent($username, $schoolID, $firstName, $lastName, $email, $password);
	public function updateParent($id, $username, $schoolID, $firstName, $lastName, $email);

	// student methods
	public function createStudent($username, $firstName, $lastName, $career, $roomNumber);
	public function importStudents($path);	
	public function updateStudent($id, $username, $firstName, $lastName, $career, $roomNumber);
	public function storeStudentSettings($id, $email, $password, $passwordConfirm);

	// Resident assistant methods
	public function createAssistant($username);	
	public function deleteAssistant($id);	
}
