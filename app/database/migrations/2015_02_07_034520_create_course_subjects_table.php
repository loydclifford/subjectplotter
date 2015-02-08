<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSubjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('course_subjects', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('school_year', 20)->index();
			$table->string('semester', 20)->index();
			$table->string('course_code', 40)->index();
			$table->string('course_year_code', 40);
			$table->string('subject_code', 40)->index();
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
		//
		Schema::dropIfExists('course_subjects');
	}

}
