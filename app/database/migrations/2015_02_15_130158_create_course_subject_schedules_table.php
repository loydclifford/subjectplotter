<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseSubjectSchedulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_subject_schedules', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('course_subject_id')->unsigned()->index();
			$table->string('room_id', 20)->index();
			$table->string('instructor_id', 20)->index();
			$table->boolean('day_mon');
			$table->boolean('day_tue');
			$table->boolean('day_wed');
			$table->boolean('day_thu');
			$table->boolean('day_fri');
			$table->boolean('day_sat');
			$table->boolean('day_sun');
			$table->dateTime('time_start');
			$table->dateTime('time_end');
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
		Schema::drop('course_subject_schedules');
	}

}
