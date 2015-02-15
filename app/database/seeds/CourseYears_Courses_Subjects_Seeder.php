<?php

class CourseYears_Courses_Subjects_Seeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $model = '';
            Eloquent::unguard();

            require_once(app_path('/includes/parsecsv.lib.php'));

            // courses loop

            $base_cy_c_s_dir = app_path('/database/seeds/_files');

            foreach (scandir($base_cy_c_s_dir) as $file_name)
            {
                if (in_array($file_name, array('.','..'))) continue;

                list($course_code, $course_year_code, $semester) = explode('_', substr($file_name, 0, -4));

                $semester = $semester == 'SECONDSEMESTER' ? 'first_semester' : 'second_semester';
                $course_code = trim($course_code);
                $course_year_code = trim($course_year_code);

                // Add course
                $course = Course::where('course_code', $course_code)->first();

                if ( ! ($course))
                {
                    $course = new Course();
                    $course->course_code = $course_code;
                    $course->description = $course_code;
                    $course->save();
                }

                $course_year = CourseYear::where('course_code', $course->course_code)->where('course_year_code', $course_year_code)->first();
                if ( ! $course_year)
                {
                    $course_year = new CourseYear();
                    $course_year->course_year_code = $course_year_code;
                    $course_year->course_code = $course_code;
                    $course_year->course_year_order = roman_to_integer($course_year_code);
                    $course_year->description = '';
                    $course_year->save();
                }

                $csv = new parseCSV();
                $csv->parseCsv($base_cy_c_s_dir.'/'.$file_name);

                foreach ($csv->data as $data)
                {
                    $subject_name  = trim(array_get($data, 'Subject'));
                    $description = trim(array_get($data, 'descriptive_title'));
                    $units  = trim(array_get($data, 'units'));
                    $units  = empty($units) ? 0 : $units;
    //                $lec  = array_get($data, 'Lec');
    //                $lab = array_get($data, 'Lab');
                    $pre_requisite  = trim(array_get($data, 'pre_requisite'));

                    if (empty($subject_name))
                    {
                        continue;
                    }

                    preg_match('/([\s\S]+)?[\D]/', $subject_name, $matches);

                    $subject_category_code = trim(isset($matches[0]) ? $matches[0] : $subject_name);
                    $subject_category_name = $subject_category_code;
                    $subject_code = Subject::generateNewId();

                    $subject_category = SubjectCategory::where('subject_category_code', $subject_category_code)->first();

                    if (!$subject_category)
                    {
                        $subject_category = new SubjectCategory();
                        $subject_category->subject_category_code = $subject_category_code;
                        $subject_category->subject_category_name = $subject_category_name;
                        $subject_category->save();
                    }

                    $subject = Subject::where('subject_name', $subject_name)->first();

                    if (!$subject )
                    {
                        $subject = new Subject();
                        $subject->subject_code = $subject_code;
                        $subject->subject_name = $subject_name;
                        $subject->units = $units;
                        $subject->description = $description;

                        // prerequisite
                        $subject->prerequisite = $subject_name;
                        $subject->subject_category_code = $subject_category_code;
                        $subject->save();
                        $model = $subject;
                    }

                    // create course subjects
                    $school_years = array(
                        '2015-2016',
                        '2014-2015',
                        '2013-2014',
                    );

                    foreach ($school_years as $school_year)
                    {
                        $course_subject = new CourseSubject();
                        $course_subject->school_year = $school_year;
                        $course_subject->semester = $semester;
                        $course_subject->course_code = $course_code;
                        $course_subject->course_year_code = $course_year_code;
                        $course_subject->subject_code = $subject->subject_code;
                        $course_subject->save();
                    }
                }
            }

            foreach (Subject::all() as $subject)
            {
                $found_subject_prerequisite = Subject::where('subject_name', $subject->prerequisite)->first();

                if ($found_subject_prerequisite)
                {
                    $subject->prerequisite = $found_subject_prerequisite->subject_code;
                    $subject->save();
                }
            }
        }
        catch (Exception $e)
        {
            echo '<pre><dd>'.var_export($model, true).'</dd></pre>';
            die();
        }
    }
}
