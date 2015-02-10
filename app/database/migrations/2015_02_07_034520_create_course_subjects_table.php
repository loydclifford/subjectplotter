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
<<<<<<< HEAD:app/database/migrations/2015_02_07_034520_create_course_subjects_table.php
		Schema::create('course_subjects', function(Blueprint $table)
=======
		Schema::create('course_years', function(Blueprint $table)
>>>>>>> a8b6d24ecdba9e6a5845a8592edf4d297902a337:app/database/migrations/2015_02_04_124443_recreate_course_years_table.php
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
<<<<<<< HEAD:app/database/migrations/2015_02_07_034520_create_course_subjects_table.php
		Schema::dropIfExists('course_subjects');
=======
		Schema::dropIfExists('course_years');
>>>>>>> a8b6d24ecdba9e6a5845a8592edf4d297902a337:app/database/migrations/2015_02_04_124443_recreate_course_years_table.php
	}

}
