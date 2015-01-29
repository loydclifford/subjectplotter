<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration {


	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('rooms', function(Blueprint $table)
		{
			$table->string('room_id', 40)->primary();
			$table->text('description');
			$table->integer('room_capacity')->default(0);

			$table->unique(['room_id']);
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
		Schema::dropIfExists('rooms');
	}
}
