<?php

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        $user = new User();
        $user->first_name = "Rex";
        $user->last_name = "Taylor";
        $user->email = "rex@gmail.com";
        $user->password = Hash::make('password');
        $user->status = 1;
        $user->confirmed = 1;
        $user->user_type = User::USER_TYPE_ADMIN;
        $user->save();

	}

}
