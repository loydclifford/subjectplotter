<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTableAndRelatedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//

		Schema::create('courses', function(Blueprint $table)
		{
			$table->string('course_code', 40)->primary();
			$table->text('description');

			$table->unique(['course_code']);
		});

		Schema::create('course_years', function(Blueprint $table)
		{
			$table->string('course_year_code', 40)->primary();
			$table->string('course_code', 40)->index();
			$table->integer('course_year_order')->index();
			$table->text('description');

			$table->unique(['course_year_code']);

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
		Schema::dropIfExists('courses');
		Schema::dropIfExists('course_years');
	}

}
