<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentSubjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('student_subjects', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('student_no')->index();
			$table->bigInteger('course_subject_id')->index();
			$table->bigInteger('course_subject_schedule_id')->index();
			$table->float('average');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
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
		Schema::dropIfExists('student_subjects');
	}

}
