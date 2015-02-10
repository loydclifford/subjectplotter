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
		$this->call('InstructorTableSeeder');
		$this->call('Course_yearsTableSeeder');
		$this->call('CourseTableSeeder');
		$this->call('RoomTableSeeder');
		$this->call('Student_subjectsTableSeeder');
		$this->call('StudentsTableSeeder');
		$this->call('Subject_categoriesTableSeeder');
		$this->call('SubjectTableSeeder');
	}

}
