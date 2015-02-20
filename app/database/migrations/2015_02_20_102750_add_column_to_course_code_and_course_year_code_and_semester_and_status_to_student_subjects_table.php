<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCourseCodeAndCourseYearCodeAndSemesterAndStatusToStudentSubjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('student_subjects', function(Blueprint $table)
		{
			$table->string('school_year', 20)->index()->nullable();
			$table->string('semester', 20)->index()->nullable();
			$table->string('course_code', 20)->index()->nullable();
			$table->string('course_year_code', 20);
			$table->string('status', 40);
		});

		Schema::table('student_subjects', function(Blueprint $table)
		{
			$table->foreign('course_code')->references('course_code')->on('courses')->onUpdate('CASCADE')->onDelete('SET NULL');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('student_subjects', function(Blueprint $table)
		{
			$table->dropForeign('fk_course_subjects_courses1');
		});

		Schema::table('student_subjects', function(Blueprint $table)
		{
			$table->dropColumn('school_year');
			$table->dropColumn('semester');
			$table->dropColumn('course_code');
			$table->dropColumn('course_year_code');
			$table->dropColumn('status');
		});
	}

}
