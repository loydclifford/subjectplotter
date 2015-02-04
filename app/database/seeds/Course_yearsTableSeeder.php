<?php

class Course_yearsTableSeeder extends Seeder {

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
            $model = new CourseYear();
            $model->course_year_code = $faker->company();
            $model->course_code = $faker->streetName();
            $model->course_year_order = $faker->numberBetween($min = 1, $max = 4);
            $model->description = $faker->realText($maxNbChars = 20, $indexSize = 1);

            $model->save();
        }
    }
}
