<?php

function school_years()
{
    $year_end = date('Y')+1;
    $year_start = date('Y');

    $ret = [];

    //@todo get the bigging of the school year intry
    $first_school_year = CourseSubject::orderBy('school_year', 'desc')->first();

    if ($first_school_year)
    {
        $years_start_end = explode('-',$first_school_year->school_year);
        $year_start = array_get($years_start_end, 0, $year_start);
    }

    for($i = $year_end; $i>=$year_start;$i--)
    {
        $school_year = ($i-1).'-'.($i);
        $ret[$school_year] = $school_year;
    }

    return $ret;
}

function get_semesters()
{
    return array(
        'first_semester' => 'First Semester',
        'second_semester' => 'Second Semester',
    );
}

function get_schedule_days($getKeyValue = NULL)
{
    $days = array(
        'day_mon' => 'Mon',
        'day_tue' => 'Tue',
        'day_wed' => 'Wed',
        'day_thu' => 'Thu',
        'day_fri' => 'Fri',
        'day_sat' => 'Sat',
        'day_sun' => 'Sun',
    );

    if (!empty($getKeyValue))
    {
        return isset($days[$getKeyValue]) ? $days[$getKeyValue] : NULL;
    }

    return $days;
}

function has_schedule_conflict($days, $timestamp_time_start, $timestamp_time_end, $room_id, \CourseSubjectSchedule $exemption = NULL)
{
    $errors = array();
    foreach ($days as $day)
    {
        $model = CourseSubjectSchedule::whereRaw('((? BETWEEN time_start AND time_end)
              OR (? BETWEEN time_start AND time_end))', array(
            date('Y-m-d H:i:s', ($timestamp_time_start + 1)),
            date('Y-m-d H:i:s', ($timestamp_time_end - 1)),
        ))->where('room_id', $room_id);

        $day_formatted = get_schedule_days($day);

        $course_subject = CourseSubject::find(Input::get('course_subject_id'));
        $school_year = $course_subject ? $course_subject->school_year : NULL;
        $semester = $course_subject ? $course_subject->semester : NULL;
        $course_code = $course_subject ? $course_subject->course_code : NULL;
        $course_year_code = $course_subject ? $course_subject->course_year_code : NULL;

        $course_subject_ids = CourseSubject::where('school_year', $school_year)
                                    ->where('semester', $semester)
                                    ->where('course_code', $course_code)
                                    ->where('course_year_code', $course_year_code)
                                    ->get()
                                    ->lists('id');

        $model_student_conflict = CourseSubjectSchedule::whereRaw('((? BETWEEN time_start AND time_end)
              OR (? BETWEEN time_start AND time_end))', array(
            date('Y-m-d H:i:s', ($timestamp_time_start + 1)),
            date('Y-m-d H:i:s', ($timestamp_time_end - 1)),
        ))->whereIn('course_subject_id', $course_subject_ids);

        // if has exemption, the current day loop is not belong
        if ($exemption && ($exemption->{$day} == 1))
        {
            $model->where('id', '<>', $exemption->id);
            $model_student_conflict->where('course_subject_id', '<>', Input::get('course_subject_id'));
        }

        switch ($day)
        {
            case 'day_mon':
                $model->where('day_mon', 1);
                $model_student_conflict->where('day_mon', 1);
                break;
            case 'day_tue':
                $model->where('day_tue', 1);
                $model_student_conflict->where('day_tue', 1);
                break;
            case 'day_wed':
                $model->where('day_wed', 1);
                $model_student_conflict->where('day_wed', 1);
                break;
            case 'day_thu':
                $model->where('day_thu', 1);
                $model_student_conflict->where('day_thu', 1);
                break;
            case 'day_fri':
                $model->where('day_fri', 1);
                $model_student_conflict->where('day_fri', 1);
                break;
            case 'day_sat':
                $model->where('day_sat', 1);
                $model_student_conflict->where('day_sat', 1);
                break;
            case 'day_sun':
                $model->where('day_sun', 1);
                $model_student_conflict->where('day_sun', 1);
                break;
        }

        $found_conflicts = $model->get();

        if (count($found_conflicts))
        {
            foreach ($found_conflicts as $course_subject_schedule)
            {
                $day_client_name = get_schedule_days($day);

                $course_code = $course_subject_schedule->courseSubject ? $course_subject_schedule->courseSubject->course_code : NULL;
                $course_year_code = $course_subject_schedule->courseSubject ? $course_subject_schedule->courseSubject->course_year_code : NULL;
                $subject_name = $course_subject_schedule->courseSubject ? $course_subject_schedule->courseSubject->subject->subject_name : NULL;

                $time_start_format = date('h:i a', strtotime($course_subject_schedule->time_start));
                $time_end_format = date('h:i a', strtotime($course_subject_schedule->time_end));

                $errors[$course_subject_schedule->id.'_'.$day] = "{$day_formatted}: {$time_start_format}-{$time_end_format}, {$course_code}-{$course_year_code}, room {$course_subject_schedule->room_id} and subject {$subject_name}.";
            }
        }


        $found_conflicts  = $model_student_conflict->get();

        if (count($found_conflicts))
        {
            foreach ($found_conflicts as $course_subject_schedule)
            {
                $day_client_name = get_schedule_days($day);

                $course_code = $course_subject_schedule->courseSubject ? $course_subject_schedule->courseSubject->course_code : NULL;
                $course_year_code = $course_subject_schedule->courseSubject ? $course_subject_schedule->courseSubject->course_year_code : NULL;
                $subject_name = $course_subject_schedule->courseSubject ? $course_subject_schedule->courseSubject->subject->subject_name : NULL;

                $time_start_format = date('h:i a', strtotime($course_subject_schedule->time_start));
                $time_end_format = date('h:i a', strtotime($course_subject_schedule->time_end));

                $errors[$course_subject_schedule->id.'_'.$day] = "{$day_formatted}: {$time_start_format}-{$time_end_format}, {$course_code}-{$course_year_code}, room {$course_subject_schedule->room_id} and subject {$subject_name}.";
            }
        }
    }

    if (count($errors))
    {
        $html_msg  = '<div class="alert alert-warning"><p>Entry has schedule conflicts. See below for conflicts info: </p><br /><ul><li><p>';
        $html_msg .= join('</li></p><li><p>', $errors);
        $html_msg .= '</p></li></ul></div>';

        return $html_msg;
    }

    return false;
}


function roman_to_integer($roman)
{
    $romans = array(
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1,
    );

    $result = 0;

    foreach ($romans as $key => $value) {
        while (strpos($roman, $key) === 0) {
            $result += $value;
            $roman = substr($roman, strlen($key));
        }
    }

    return $result;
}

function get_current_school_year()
{
    $year = date('Y', time());
    return $year . '-' . ($year+1);
}