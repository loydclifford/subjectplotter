<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentSubjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('student_subjects', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('student_no', 20)->index();
			$table->bigInteger('course_subject_id')->unsigned()->index();
			$table->bigInteger('course_subject_schedule_id')->unsigned()->index();
			$table->float('average');
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
		Schema::drop('student_subjects');
	}

}
