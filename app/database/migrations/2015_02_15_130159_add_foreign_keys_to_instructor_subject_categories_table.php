<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInstructorSubjectCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('instructor_subject_categories', function(Blueprint $table)
		{
			$table->foreign('instructor_id', 'fk_instructor_subject_categories_instructors1')->references('id')->on('instructors')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('subject_category_code', 'fk_instructor_subject_categories_subject_categories1')->references('subject_category_code')->on('subject_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('instructor_subject_categories', function(Blueprint $table)
		{
			$table->dropForeign('fk_instructor_subject_categories_instructors1');
			$table->dropForeign('fk_instructor_subject_categories_subject_categories1');
		});
	}

}
