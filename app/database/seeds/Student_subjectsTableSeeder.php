<?php

class Student_subjectsTableSeeder extends Seeder {

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
            $model = new StudentSubject();
            $model->id = $i+1;
            $model->student_no = $faker->numberBetween($min = 1, $max = 20);
            $model->course_subject_id = $faker->company();
            $model->course_subject_schedule_id = $faker->numberBetween($min = 100, $max = 200);
            $model->average = $faker->latitude();
            $model->created_at = $faker->dateTime->format('Y-m-d');
            $model->updated_at = $faker->dateTime->format('Y-m-d');

            $model->save(); 
        }
	}
}
