<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Add columns to tickets table
		Schema::table('tickets', function($table)
		{
		    $table->char('phone', 10);
		    $table->integer('type');
		});

		// change coordinates to nullable
		DB::statement('ALTER TABLE `tickets` MODIFY `latitude` DECIMAL(10,8) NULL;');
		DB::statement('ALTER TABLE `tickets` MODIFY `longitude` DECIMAL(11,8) NULL;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tickets', function($table)
		{
		    $table->dropColumn('phone');
		    $table->dropColumn('type');
		});

		// change coordinates to not nullable
		DB::statement('ALTER TABLE `tickets` MODIFY `latitude` DECIMAL(10,8) NOT NULL;');
		DB::statement('ALTER TABLE `tickets` MODIFY `longitude` DECIMAL(11,8) NOT NULL;');
	}
}
