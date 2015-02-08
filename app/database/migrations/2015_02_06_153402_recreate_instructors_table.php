<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateInstructorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::dropIfExists('instructors');
		Schema::create('instructors', function(Blueprint $table)
		{
			$table->string('id',40);
			$table->integer('user_id')->index();
			$table->timestamps();

			$table->primary('id');
		});

		Schema::dropIfExists('instructor_subject_categories');
		Schema::create('instructor_subject_categories', function(Blueprint $table)
		{
			$table->string('instructor_id',40)->index();
			$table->string('subject_category_code',40)->index();
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
		Schema::dropIfExists('instructors');
	}

}
