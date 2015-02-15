<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCourseSubjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('course_subjects', function(Blueprint $table)
		{
			$table->foreign('course_code', 'fk_course_subjects_courses1')->references('course_code')->on('courses')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('subject_code', 'fk_course_subjects_subjects1')->references('subject_code')->on('subjects')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('course_subjects', function(Blueprint $table)
		{
			$table->dropForeign('fk_course_subjects_courses1');
			$table->dropForeign('fk_course_subjects_subjects1');
		});
	}

}
