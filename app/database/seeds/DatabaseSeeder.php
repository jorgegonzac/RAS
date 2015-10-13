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
	 	DB::table('users')->delete();
		User::create(array(
		        'first_name'     => 'Jorge Luis',
		        'last_name' => 'González Sánchez',
		        'room_number'	=>	101,
		        'career'	=>	'ISC',
		        'password' => Hash::make('password'),
	    ));
		// $this->call('UserTableSeeder');
	}

}
