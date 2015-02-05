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
		Schema::create('StudentSubjects', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('student_no')->unique();
			$table->string('course_subject_id', 20)->unique();
			$table->string('course_subject_schedule_id', 20)->unique();
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
		Schema::dropIfExists('StudentSubjects');
	}

}
