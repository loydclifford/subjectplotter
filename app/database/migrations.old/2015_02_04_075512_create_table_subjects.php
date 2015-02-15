<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSubjects extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('subject_categories', function(Blueprint $table)
		{
			$table->string('subject_category_code', 20);
			$table->string('subject_category_name', 255);
			$table->dateTime('created_at');
			$table->dateTime('updated_at');

			$table->primary('subject_category_code');
		});

		Schema::create('subjects', function(Blueprint $table)
		{
			$table->string('subject_code', 20)->primary();
			$table->string('subject_name', 255);
			$table->integer('units')->default(0);
			$table->text('description');
			$table->string('prerequisite', 20);
			$table->string('subject_category_code', 20);
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
		Schema::dropIfExists('subject_categories');
		Schema::dropIfExists('subjects');
	}

}
