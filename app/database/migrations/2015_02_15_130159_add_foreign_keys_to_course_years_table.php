<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCourseYearsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('course_years', function(Blueprint $table)
		{
			$table->foreign('course_code', 'fk_course_years_courses1')->references('course_code')->on('courses')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('course_years', function(Blueprint $table)
		{
			$table->dropForeign('fk_course_years_courses1');
		});
	}

}
