<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserRolesFk extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE `users_roles` MODIFY `user_id` INT(10) UNSIGNED NOT NULL;');
		DB::statement('ALTER TABLE `users_roles` MODIFY `role_id` INT(10) UNSIGNED NOT NULL;');
		DB::statement('ALTER TABLE users_roles ADD FOREIGN KEY (user_id) REFERENCES users(id)');
		DB::statement('ALTER TABLE users_roles ADD FOREIGN KEY (role_id) REFERENCES roles(id)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE `users_roles` DROP FOREIGN KEY fk_user_id');
		DB::statement('ALTER TABLE `users_roles` DROP FOREIGN KEY fk_role_id');
		DB::statement('ALTER TABLE `users_roles` MODIFY `user_id` INT(11) NOT NULL;');
		DB::statement('ALTER TABLE `users_roles` MODIFY `role_id` INT(11) NOT NULL;');
	}

}
