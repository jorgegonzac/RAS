<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersAddNullable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		DB::statement('ALTER TABLE `users` MODIFY `room_number` INTEGER(11) NULL;');
		DB::statement('ALTER TABLE `users` MODIFY `career` VARCHAR(5) NULL;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		DB::statement('ALTER TABLE `users` MODIFY `room_number` INTEGER(11) NULL;');
		DB::statement('ALTER TABLE `users` MODIFY `career` VARCHAR(5) NOT NULL;');
	}

}
