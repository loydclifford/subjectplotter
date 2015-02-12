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

        DB::table('subject_categories')->truncate();

        $subject_categories = array(
            'IT'              => 'IT',
            'ENGLISH'         => 'English',
            'FILIPINO'        => 'Filipino',
            'MATH'            => 'Math',
            'HISTORY'         => 'History',
            'NATURAL SCIENCE' => 'Natural Sciences',
            'SOCIAL SCIENCE'  => 'Social Science',
            'PE'              => 'PE',
            'NSTP'            => 'NSTP',
            'ACCOUNTING'      => 'Accounting ',
            'PHYSICS'         => 'Physics',
            'SPANISH'         => 'Spanish',
            'LITRATURE'       => 'Litrature',
            'VALUES'          => 'Values',
            'HUMANITIES'      => 'Humanities',
            'IT ELECTIVE'     => 'IT Elective',
            'FREE ELECTIVE'   => 'Free Elective',
            'RIZAL'           => 'Rizal',
        );

        foreach ($subject_categories as $key=>$value)
        {
            $model = new SubjectCategory();
            $model->subject_category_code = $key;
            $model->subject_category_name = $value;
            $model->created_at = date('Y-m-d', time());
            $model->updated_at = date('Y-m-d', time());
            $model->save();
        }
	}
}
