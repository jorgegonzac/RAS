<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampsReportsTickets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tickets', function($table)
		{
		    $table->timestamps();
		});
		
		Schema::table('reports', function($table)
		{
		    $table->timestamps();
		});
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
		    $table->dropColumn('updated_at');
		    $table->dropColumn('created_at');
		});

		Schema::table('reports', function($table)
		{
		    $table->dropColumn('updated_at');
		    $table->dropColumn('created_at');
		});
	}

}
