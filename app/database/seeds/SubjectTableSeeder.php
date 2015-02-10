<?php

class SubjectTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        DB::table('subjects')->truncate();

        $i1 = 0;
        foreach (SubjectCategory::all() as $subject_category)
        {
            for ($i=1;$i<5;$i++)
            {
                $model = new Subject();
                $model->subject_category_code = $subject_category->subject_category_code;
                $model->subject_code = 'SUB-20'.$i.$i1;
                $model->subject_name = $subject_category->subject_category_name . ' ' . $i;
                $model->units = 3;
                $model->description  = $model->subject_name;
                $model->prerequisite = $subject_category->subject_category_code;
                $model->created_at   = date('Y-m-d', time());
                $model->updated_at   = date('Y-m-d', time());
                $model->save();
            }

            $i1++;
        }
	}
}
