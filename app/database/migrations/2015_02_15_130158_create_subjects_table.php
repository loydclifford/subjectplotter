<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subjects', function(Blueprint $table)
		{
			$table->string('subject_code', 20)->primary();
			$table->string('subject_name');
			$table->integer('units')->default(0);
			$table->text('description', 65535);
			$table->string('prerequisite', 20);
			$table->string('subject_category_code', 20)->index('fk_subjects_subject_categories1_idx');
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
		Schema::drop('subjects');
	}

}
