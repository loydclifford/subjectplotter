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

		$this->call('Course_yearsTableSeeder');
		$this->call('CourseTableSeeder');
	//  $this->call('DatabaseSeeder.php');
		$this->call('RoomTableSeeder');
		$this->call('Student_subjectsTableSeeder');
		$this->call('StudentsTableSeeder');
		$this->call('Subject_categoriesTableSeeder');
		$this->call('SubjectTableSeeder');
		$this->call('UserTableSeeder');
	}

}
