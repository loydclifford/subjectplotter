<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseYearsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_years', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('course_year_code', 20);
			$table->string('course_code', 20)->index();
			$table->integer('course_year_order')->index();
			$table->text('description', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('course_years');
	}

}
