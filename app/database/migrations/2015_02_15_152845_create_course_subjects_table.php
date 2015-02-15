<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseSubjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_subjects', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('school_year', 20)->index();
			$table->string('semester', 20)->index();
			$table->string('course_code', 20)->index();
			$table->string('course_year_code', 20);
			$table->string('subject_code', 20)->index();
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
		Schema::drop('course_subjects');
	}

}
