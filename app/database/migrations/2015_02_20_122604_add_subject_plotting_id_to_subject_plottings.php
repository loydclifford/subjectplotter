<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubjectPlottingIdToSubjectPlottings extends Migration {

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
			$table->bigInteger('student_plotting_id')->index();
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
		Schema::table('student_subjects', function(Blueprint $table)
		{
			$table->dropColumn('student_plotting_id');
		});
	}

}
