<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelatedTableForInstructors extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('instructors', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->index();
			$table->timestamps();
		});

		Schema::create('instructor_subject_categories', function(Blueprint $table)
		{
			$table->integer('instructor_id')->index();
			$table->string('subject_category_code', 20)->index();
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
		Schema::dropIfExists('course_years');
		Schema::dropIfExists('instructor_subject_categories');
	}

}
