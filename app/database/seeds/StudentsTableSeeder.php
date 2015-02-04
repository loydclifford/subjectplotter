<?php

class StudentsTableSeeder extends Seeder {

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

        for ($i = 0; $i < 20; $i++)
        {
            $model = new Student();
            $model->course_code = $faker->company();
            $model->course_level_code = $faker->randomElement(array(
                'I',
                'II',
                'III',
                'IV'
            ));
            $model->user_id = $faker->numberBetween($min = 1, $max = 20);
            $model->first_name = $faker->firstName;
            $model->last_name = $faker->lastName;
            $model->created_at = $faker->dateTime->format('Y-m-d');
            $model->updated_at = $faker->dateTime->format('Y-m-d');

            $model->save();
        }
	}
}
