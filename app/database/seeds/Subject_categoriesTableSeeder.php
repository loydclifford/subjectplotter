<?php

class Subject_categoriesTableSeeder extends Seeder {

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
            $model = new SubjectCategories();
            $model->subject_category_code = $faker->unique()->numberBetween(0123456, 9999999);
            $model->subject_category_name = $faker->lastName;
            $model->created_at = $faker->dateTime->format('Y-m-d');
            $model->updated_at = $faker->dateTime->format('Y-m-d');
            
            $model->save();
        }
	}
}
