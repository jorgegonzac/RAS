<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		ini_set('memory_limit','256M');
	 	
	 	// Delete data in tables
	 	DB::table('users')->delete();
						
	 	// Create student user
		User::create(array(
		        'first_name'     => 'Jorge Luis',
		        'last_name' => 'González Sánchez',
		        'room_number'	=>	101,
		        'career'	=>	'ISC',
		        'username' => 'A00567911',		        
	    ));

	 	// Create admin user
		$admin = User::create(array(
		        'first_name'     => 'Admin',
		        'last_name' => 'Last Name',
		        'username' => 'admin',
		        'password' => Hash::make('admin'),		        
	    ));
	 	// Create parent user
		$parent = User::create(array(
		        'first_name'     => 'Parent',
		        'last_name' => 'Last Name',
		        'username' => 'parent',
		        'password' => Hash::make('parent'),		      
		        'user_id' => $user->id,  
	    ));

	}
}
