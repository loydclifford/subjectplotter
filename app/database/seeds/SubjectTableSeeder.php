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
<<<<<<< HEAD
            for ($i=1;$i<5;$i++)
            {
                $model = new Subject();
                $model->subject_category_code = $subject_category->subject_category_code;
                $model->subject_code = 'SUB-20'.$i.$i1;
                $model->subject_name = $subject_category->subject_category_name . ' ' . $i;
                $model->units = 3;
                $model->description = $model->subject_name;
                $model->prerequisite = $subject_category->subject_category_code;
                $model->created_at = date('Y-m-d', time());
                $model->updated_at = date('Y-m-d', time());
                $model->save();
            }

            $i1++;
=======
            $model = new Subject();
            $model->subject_code = 'SUB-'.$faker->unique()->numberBetween($min = 99, $max = 999);
            $model->subject_name = $faker->randomElement(array(
                'ENGLISH',
                'FILIPINO',
                'PSYCHOLOGY',
                'SOCIAL SCIENCE',
                'PHILOSOPHY',
                'NATIONAL SCIENCE',
                'MATH',
                'ACCOUNTING',
                'IT',
                'HRM',
                'TM',
                'PE',
                'CHINESE',
                'SPANISH',
                'CEBUANO',
                'LITERATURE',
                'EDUC'
            ));
            $model->units = $faker->numberBetween($min = 2, $max = 4);
            $model->description = $faker->realText($maxNbChars = 10, $indexSize = 1);
            $model->prerequisite = $faker->safeColorName();
            $model->subject_category_code = $faker->word();
            $model->created_at = $faker->dateTime->format('Y-m-d');
            $model->updated_at = $faker->dateTime->format('Y-m-d');

            $model->save();
>>>>>>> a8b6d24ecdba9e6a5845a8592edf4d297902a337
        }
	}
}
