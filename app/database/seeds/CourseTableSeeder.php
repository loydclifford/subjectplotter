<?php

class CourseTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        $user = new Course();
        $user->course_code = "BSIT";
        $user->description = "Bachelor of science and Information Technology";
        $user->save();

        $user = new Course();
        $user->course_code = "HRM";
        $user->description = "Hotel and Restaurant Management";
        $user->save();
	}
}
