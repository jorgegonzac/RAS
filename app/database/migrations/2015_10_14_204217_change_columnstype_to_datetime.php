<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnstypeToDatetime extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE `reports` MODIFY `date` DATETIME;');
		DB::statement('ALTER TABLE `tickets` MODIFY `check_in` DATETIME NULL;');
		DB::statement('ALTER TABLE `tickets` MODIFY `check_out` DATETIME NULL;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE `reports` MODIFY `date` TIME;');
		DB::statement('ALTER TABLE `tickets` MODIFY `check_in` TIME NOT NULL;');
		DB::statement('ALTER TABLE `tickets` MODIFY `check_out` TIME NOT NULL;');
	}

}
