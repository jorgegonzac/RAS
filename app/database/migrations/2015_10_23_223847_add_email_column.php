<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Add an email column so the system can send important info to parents
		Schema::table('users', function($table)
		{
		    $table->string('email')->nullable;
		});

		// Laravel doesn't make columns nullabe, so i need to do this
		DB::statement('ALTER TABLE `users` MODIFY `email` varchar(50) NULL;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table)
		{
		    $table->dropColumn('email');
		});
	}

}
