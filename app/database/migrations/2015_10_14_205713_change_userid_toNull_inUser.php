<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUseridToNullInUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE `users` DROP FOREIGN KEY users_ibfk_1');
		DB::statement('ALTER TABLE `users` MODIFY `user_id` int(10) unsigned NULL;');
		DB::statement('ALTER TABLE users ADD FOREIGN KEY (user_id) REFERENCES users(id)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE `users` DROP FOREIGN KEY users_ibfk_1');
		DB::statement('ALTER TABLE `users` MODIFY `user_id` int(10) unsigned NOT NULL;');
		DB::statement('ALTER TABLE users ADD FOREIGN KEY (user_id) REFERENCES users(id)');
	}

}
