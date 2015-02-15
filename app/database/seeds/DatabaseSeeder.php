<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
		$this->call('RoomTableSeeder');

		$this->call('CourseYears_Courses_Subjects_Seeder');

		$this->call('StudentsTableSeeder');
		$this->call('InstructorTableSeeder');
	}

}
