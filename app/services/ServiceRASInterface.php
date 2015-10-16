<?php
namespace services;

interface ServiceRASInterface 
{  
	public function authenticate($username, $password);
	public function createTicket($username, $place, $phone, $type, $checkIn);
	public function getOpenTicket($username);
}
