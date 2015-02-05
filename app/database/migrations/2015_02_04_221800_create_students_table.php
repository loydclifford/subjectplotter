<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('students', function(Blueprint $table)
		{
			$table->bigInteger('student_no', true);
			$table->string('course_code', 20);
			$table->string('course_level_code', 20);
			$table->bigInteger('user_id');
			$table->string('first_name', 255)->index();
			$table->string('last_name', 255)->index();
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
		Schema::dropIfExists('students');
	}

}
