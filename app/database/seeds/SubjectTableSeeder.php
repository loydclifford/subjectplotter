<?php

class SubjectTableSeeder extends Seeder {

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
            $model = new Subject();
            $model->subject_code = $faker->primary()->numberBetween($min = 0123456, $max = 9999999);
            $model->subject_name = $faker->lastName;
            $model->units = $faker->numberBetween($min = 1, $max = 4);
            $model->description = $faker->realText($maxNbChars = 20, $indexSize = 1);
            $model->prerequisite = $faker->safeColorName();
            $model->subject_category_code = $faker->userName();
            $model->created_at = $faker->dateTime->format('Y-m-d');
            $model->updated_at = $faker->dateTime->format('Y-m-d');
            
            $model->save();
        }
	}
}
