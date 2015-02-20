<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentSubjectPlottedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::dropIfExists('student_plotting');
		Schema::create('student_plotting', function(Blueprint $table)
		{
			$table->bigIncrements('id');

			$table->string('student_no', 20);
			$table->string('status', 40)->index();
			$table->string('school_year', 20)->index();
			$table->string('semester', 20)->index();
			$table->string('course_code', 20)->index();
			$table->string('course_year_code', 20);

			$table->foreign('course_code', 'fk_student_plotting_courses1')->references('course_code')->on('courses')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('student_no', 'fk_student_subject_plotting_students1')->references('student_no')->on('students')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::dropIfExists('student_plotting');
	}

}
