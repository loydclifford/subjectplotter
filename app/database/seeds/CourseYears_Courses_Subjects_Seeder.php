<?php

class CourseYears_Courses_Subjects_Seeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        require_once(app_path('/includes/parsecsv.lib.php'));

        // courses loop

        $base_cy_c_s_dir = app_path('/database/seeds/_files');

        foreach (scandir($base_cy_c_s_dir) as $file_name)
        {
            if (in_array($file_name, array('.','..'))) continue;

            list($course, $course_level, $semester) = explode('_', substr($file_name, 0, -4));


            // Add course
            $course = new Course();
            $course->course_code = $course;
            $course->description = $course;
            //$course->save();

            $course_years = new CourseYear();
            $course_years->course_year_code = $course_level;
            $course_years->course_code = $course->course_code;
            $course_years->course_year_order = roman_to_integer($course_level);
            $course_years->description = '';
            //$course_years->save();


            $csv = new parseCSV();
            $csv->parseCsv($base_cy_c_s_dir.'/'.$file_name);

            foreach ($csv->data as $data)
            {
                $semester  = array_get($data, 'Second Semester');
                $description = array_get($data, 'Descriptive Title');
                $units  = array_get($data, 'Units');
                $lec  = array_get($data, 'Lec');
                $lab = array_get($data, 'Lab');
                $pre_requisite  = array_get($data, 'Pre Requisite');
            }



        }
    }
}
