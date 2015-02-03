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



        // require the Faker autoloader
        require_once base_path('/vendor/fzaninotto/faker/src/autoload.php');
        // alternatively, use another PSR-0 compliant autoloader (like the Symfony2 ClassLoader for instance)

        // use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 500; $i++)
        {
            $user = new User();
            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->email = $faker->email();
            $user->password = Hash::make($faker->dateTime->format('Y-m-d'));
            $user->status = $faker->boolean();
            $user->confirmed = $faker->boolean();
            $user->user_type = $faker->randomElement(array(
                    User::USER_TYPE_ADMIN,
                    User::USER_TYPE_STUDENT,
                    User::USER_TYPE_INSTRUCTOR,
            ));
            $user->save();
        }
	}
}
