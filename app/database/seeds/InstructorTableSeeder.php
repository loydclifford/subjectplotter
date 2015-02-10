<?php

class InstructorTableSeeder extends Seeder {

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
            $user = new User();
            $user->first_name = $faker->firstName;
            $user->last_name  = $faker->lastName;
            $user->email      = $faker->unique()->email();
            $user->password   = Hash::make($faker->dateTime->format('Y-m-d'));
            $user->status     = User::STATUS_ACTIVE;
            $user->confirmed  = 1;
            $user->user_type  = User::USER_TYPE_INSTRUCTOR;
            $user->save();

            $instructor = new Instructor();
            $instructor->user_id = $user->id;
            $instructor_id = Instructor::generateNewId();
            $instructor->id = $instructor_id;
            $instructor->save();

            foreach (SubjectCategory::all() as $subject_category)
            {
                if ($faker->boolean())
                {
                    $instructor_subject_category = new InstructorSubjectCategory();

                    $instructor_subject_category->subject_category_code = $subject_category->subject_category_code;
                    $instructor_subject_category->instructor_id = $instructor_id;

                    $instructor_subject_category->save();
                }
            }
        }
	}
}
