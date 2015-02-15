<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('students', function(Blueprint $table)
		{
			$table->bigInteger('student_no', true)->unsigned();
			$table->string('course_code', 20)->index('fk_students_courses1_idx');
			$table->string('course_year_code', 20);
			$table->bigInteger('user_id')->unsigned()->index('fk_students_users1_idx');
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
		Schema::drop('students');
	}

}
