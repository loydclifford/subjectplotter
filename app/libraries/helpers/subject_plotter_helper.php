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

function has_schedule_conflict($days, $timestamp_time_start, $timestamp_time_end, $room_id, $exemption_id = NULL)
{
    $errors = array();
    foreach ($days as $day)
    {
        $model = CourseSubjectSchedule::whereRaw('((? BETWEEN time_start AND time_end)
              OR (? BETWEEN time_start AND time_end))', array(
            date('Y-m-d H:i:s', ($timestamp_time_start + 1)),
            date('Y-m-d H:i:s', ($timestamp_time_end + 1)),
        ))->where('room_id', $room_id);

        if ($exemption_id)
        {
            $model->where('id', '<>', $exemption_id);
        }

        switch ($day)
        {
            case 'day_mon':
                $model->where('day_mon', 1);
                break;
            case 'day_tue':
                $model->where('day_tue', 1);
                break;
            case 'day_wed':
                $model->where('day_wed', 1);
                break;
            case 'day_thu':
                $model->where('day_wed', 1);
                break;
            case 'day_fri':
                $model->where('day_wed', 1);
                break;
            case 'day_sat':
                $model->where('day_wed', 1);
                break;
            case 'day_sun':
                $model->where('day_wed', 1);
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
                $semester = $course_subject_schedule->courseSubject ? $course_subject_schedule->courseSubject->semester : NULL;
                $subject_code = $course_subject_schedule->courseSubject ? $course_subject_schedule->courseSubject->subject_code : NULL;

                $errors[] = "Conflict with schedule day {$day_client_name}, room {$course_subject_schedule->room_id} and subject {$subject_code} from {$course_code}-{$course_year_code} ({$semester}).";
            }
        }
    }

    if (count($errors))
    {
        $html_msg  = '<div class="alert alert-warning"><p>One of the selected day conflicts with room and time. See below for conflicts info:</p><p>';
        $html_msg .= join('</p><p>', $errors);
        $html_msg .= '</p></div>';

        return $html_msg;
    }

    return false;
}
