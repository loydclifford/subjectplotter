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

		DB::table('courses')->delete();

        $user = new Course();
        $user->course_code = "BSIT";
        $user->description = "Bachelor of science and Information Technology";
        $user->save();

        $user = new Course();
        $user->course_code = "BSHRM";
        $user->description = "Bachelor of science in Hotel and Restaurant Management";
        $user->save();

        $user = new Course();
        $user->course_code = "BSTM";
        $user->description = "Bachelor of Science in Tourism Management";
        $user->save();

        $user = new Course();
        $user->course_code = "BSED";
        $user->description = "Bachelor of science in Education";
        $user->save();

        $user = new Course();
        $user->course_code = "BEED";
        $user->description = "Bachelor of science in Elementary Education";
        $user->save();

        $user = new Course();
        $user->course_code = "BSDEV";
        $user->description = "Bachelor of science in Development Communication";
        $user->save();
    }
}
