<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCourseSubjectSchedulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('course_subject_schedules', function(Blueprint $table)
		{
			$table->foreign('course_subject_id', 'fk_course_subject_schedules_course_subjects1')->references('id')->on('course_subjects')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('room_id', 'fk_course_subject_schedules_rooms1')->references('room_id')->on('rooms')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('instructor_id', 'fk_course_subject_schedules_instructors1')->references('id')->on('instructors')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('course_subject_schedules', function(Blueprint $table)
		{
			$table->dropForeign('fk_course_subject_schedules_course_subjects1');
			$table->dropForeign('fk_course_subject_schedules_rooms1');
			$table->dropForeign('fk_course_subject_schedules_instructors1');
		});
	}

}
