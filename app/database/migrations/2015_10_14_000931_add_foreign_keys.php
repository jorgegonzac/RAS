<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Add user_id column to users table in order to create foreign key
		Schema::table('users', function($table)
		{
		    $table->integer('user_id')->references('id')->on('user')->nullable();		    
		});

		// Alter table in order to set the attributes to the same data type 		
		DB::statement('ALTER TABLE `reports` MODIFY `user_id` INT(10) UNSIGNED NOT NULL;');
		DB::statement('ALTER TABLE `roles_privilages` MODIFY `role_id` INT(10) UNSIGNED NOT NULL;');
		DB::statement('ALTER TABLE `roles_privilages` MODIFY `privilege_id` INT(10) UNSIGNED NOT NULL;');
		DB::statement('ALTER TABLE `tickets` MODIFY `user_id` INT(10) UNSIGNED NOT NULL;');
		DB::statement('ALTER TABLE `users` MODIFY `user_id` INT(10) UNSIGNED NOT NULL;');

		DB::statement('ALTER TABLE reports ADD FOREIGN KEY (user_id) REFERENCES users(id)');
		DB::statement('ALTER TABLE roles_privilages ADD FOREIGN KEY (role_id) REFERENCES roles(id)');
		DB::statement('ALTER TABLE roles_privilages ADD FOREIGN KEY (privilege_id) REFERENCES privilages(id)');
		DB::statement('ALTER TABLE tickets ADD FOREIGN KEY (user_id) REFERENCES users(id)');
		DB::statement('ALTER TABLE users ADD FOREIGN KEY (user_id) REFERENCES users(id)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		DB::statement('ALTER TABLE `reports` DROP FOREIGN KEY fk_user_id');
		DB::statement('ALTER TABLE `roles_privilages` DROP FOREIGN KEY fk_role_id');
		DB::statement('ALTER TABLE `roles_privilages` DROP FOREIGN KEY fk_privilege_id');
		DB::statement('ALTER TABLE `tickets` DROP FOREIGN KEY fk_user_id');
		DB::statement('ALTER TABLE `users` DROP FOREIGN KEY fk_user_id');

		Schema::table('users', function($table)
		{
		    $table->dropColumn('user_id');
		});
	}

}
