<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntitiesTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 
		
		Schema::create('users', function($t) {
			$t->increments('id');
			$t->string('first_name',20); 
			$t->string('last_name',20); 
			$t->integer('room_number');
			$t->string('career',5);
			$t->string('password',200);
			$t->integer('user_id')->references('id')->on('user')->nullable();
		});

		/*
		*
		*Tickets: an entitie where  absence reports are saved. 
		*
		*/
		Schema::create('tickets', function($t) {
			$t->increments('id');
			$t->string('place',50); 
			$t->time('check_in');
			$t->time('check_out');
			$t->decimal('latitude',10,8);
			$t->decimal('longitude',11,8);
			$t->integer('user_id')->references('id')->on('user');
		});

		/*
		*Reports: an entitie where the disciplinary reports are saved 
		*/
		Schema::create('reports', function($t) {
			$t->increments('id');
			$t->string('description',300); 
			$t->time('date');
			$t->integer('user_id')->references('id')->on('user');
		});

		Schema::create('roles', function($t){
			$t->increments('id');
			$t->string('description',20);
			$t->timestamps();
		});

		Schema::create('privilages', function($t){
			$t->increments('id');
			$t->string('description',20);
			$t->timestamps();
		});
		/**
		 * Many to many between users and roles
		 */
		Schema::create('users_roles', function($t){
			$t->increments('id');
			$t->integer('user_id')->references('id')->on('users');				
			$t->integer('role_id')->references('id')->on('roles');								
			$t->timestamps();
		});	
		/**
		 * Many to many between roles and privilages
		 */
		Schema::create('roles_privilages', function($t){
			$t->increments('id');
			$t->integer('role_id')->references('id')->on('roles');				
			$t->integer('privilege_id')->references('id')->on('privilages');								
			$t->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('tickets');
		Schema::drop('users');
		Schema::drop('reports');
		Schema::drop('roles');
		Schema::drop('privilages');
		Schema::drop('users_roles');
		Schema::drop('roles_privilages');
		
	}

}
