<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('user_type', 40)->index();
			$table->string('first_name');
			$table->string('last_name')->nullable()->index();
			$table->string('email')->nullable()->unique();
			$table->string('password');
			$table->string('status', 40)->index();
			$table->string('confirmation_code')->nullable()->index();
			$table->boolean('confirmed')->default(0);
			$table->dateTime('last_login')->nullable();
			$table->date('registration_date')->nullable()->index();
			$table->string('remember_token')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
