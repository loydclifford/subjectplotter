<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToStudentSubjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('student_subjects', function(Blueprint $table)
		{
			$table->foreign('student_no', 'fk_student_subjects_students1')->references('student_no')->on('students')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('course_subject_id', 'fk_student_subjects_course_subjects1')->references('id')->on('course_subjects')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('course_subject_schedule_id', 'fk_student_subjects_course_subject_schedules1')->references('id')->on('course_subject_schedules')->onUpdate('CASCADE')->onDelete('CASCADE');
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
			$table->dropForeign('fk_student_subjects_students1');
			$table->dropForeign('fk_student_subjects_course_subjects1');
			$table->dropForeign('fk_student_subjects_course_subject_schedules1');
		});
	}

}
