<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInstructorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('instructors', function(Blueprint $table)
		{
			$table->foreign('user_id', 'fk_instructors_users')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('instructors', function(Blueprint $table)
		{
			$table->dropForeign('fk_instructors_users');
		});
	}

}
