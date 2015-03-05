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

        $user = new User();
        $user->first_name = $faker->firstName;
        $user->last_name  = $faker->lastName;
        $user->email      = 'subjectstudent@gmail.com';
        $user->password   = Hash::make('password');
        $user->status     = User::STATUS_ACTIVE;
        $user->confirmed  = 1;
        $user->user_type  = User::USER_TYPE_STUDENT;
        $user->save();

        $model = new Student();
        $model->student_no =  Student::generateStudentNo();
        $model->course_code =  'BSIT';
        $model->course_year_code = 'I';
        $model->user_id    = $user->id;

        $model->save();

        for ($i = 0; $i < 20; $i++)
        {
            $user = new User();
            $user->first_name = $faker->firstName;
            $user->last_name  = $faker->lastName;
            $user->email      = $faker->unique()->email();
            $user->password   = Hash::make('password');
            $user->status     = User::STATUS_ACTIVE;
            $user->confirmed  = 1;
            $user->user_type  = User::USER_TYPE_STUDENT;
            $user->save();

            $model = new Student();
            $model->student_no =  Student::generateStudentNo();
            $model->course_code =  $faker->randomElement(Course::all()->lists('course_code'));
            $model->course_year_code = $faker->randomElement(array(
                'I',
                'II',
                'III',
            ));
            $model->user_id    = $user->id;

            $model->save();
        }
	}
}
