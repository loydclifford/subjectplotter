<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAverageColumnFromStudentSubjects extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//

		Schema::table('student_subjects', function(Blueprint $table)
		{
			$table->dropColumn('average');
		});
		Schema::table('student_subjects', function(Blueprint $table)
		{
			$table->string('average',10)->default('NA')->nullable();
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
	}

}
