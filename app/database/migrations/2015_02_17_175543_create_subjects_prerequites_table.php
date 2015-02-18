<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsPrerequitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subjects', function(Blueprint $table) {
			if (Schema::hasColumn('subjects', 'prerequisite')) $table->dropColumn('prerequisite');
		});

		//
		Schema::dropIfExists('subject_prerequisites');
		Schema::create('subject_prerequisites', function(Blueprint $table)
		{
			$table->string('subject_code', 20);
			$table->string('prerequisite_subject_code', 20);

			$table->primary(array(
				'subject_code',
				'prerequisite_subject_code'
			), 'subject_pres_subject_code_pres_subjects_primary');

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
		Schema::dropIfExists('subject_prerequisites');
	}

}
