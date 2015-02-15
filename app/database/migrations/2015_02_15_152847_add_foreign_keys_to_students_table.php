<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToStudentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('students', function(Blueprint $table)
		{
			$table->foreign('course_code', 'fk_students_courses1')->references('course_code')->on('courses')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('user_id', 'fk_students_users1')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('students', function(Blueprint $table)
		{
			$table->dropForeign('fk_students_courses1');
			$table->dropForeign('fk_students_users1');
		});
	}

}
