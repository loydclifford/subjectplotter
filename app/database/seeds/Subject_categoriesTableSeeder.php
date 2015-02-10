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
            'MATH'    => 'Math',
            'SPANISH' => 'Spanish',
            'CHINESE' => 'Chinese',
            'ENGLISH' => 'English',
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
