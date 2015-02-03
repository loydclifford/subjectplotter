<?php

class RoomTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        // require the Faker autoloader
        require_once base_path('/vendor/fzaninotto/faker/src/autoload.php');
        // alternatively, use another PSR-0 compliant autoloader (like the Symfony2 ClassLoader for instance)

        // use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 30; $i++)
        {
            $model = new Room();
            $model->room_id = 'RM-0'.($i+1);
            $model->description = $faker->text;
            $model->room_capacity = 60;

            $model->save();
        }

	}
}
