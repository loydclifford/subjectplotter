<?php

class SubjectScheduleSetSchedulesController extends BaseController {

    /**
     * General
     *
     * @return \Illuminate\View\View|string
     */
    public function getIndex()
    {
        // Set to session if has parameter
        if (Input::has('semester') && Input::has('course_year_code'))
        {
            Session::put('selected_semester', Input::get('semester'));
            Session::put('selected_course_year_code', Input::get('course_year_code'));
        }

        // Set to session if has set subject code
        if (Input::has('course_subject_id'))
        {
            Session::put('selected_course_subject_id', Input::get('course_subject_id'));
        }

        // Lists
        $this->data['meta']->title  = lang('subjectschedule/setschedules.page_title');
        $this->data['course']  = Course::find(Session::get('selected_course_code'));
        $this->data['school_year']  = Session::get('selected_school_year');
        $this->data['semester']  = Session::get('selected_semester');
        $this->data['course_year_code']  = Session::get('selected_course_year_code');

        $this->data['selected_course_subject']  = CourseSubject::find(Session::get('selected_course_subject_id'));

        $this->data['course_subjects']  = CourseSubject::with('subject')
                                            ->where('school_year', $this->data['school_year'])
                                            ->where('semester', $this->data['semester'])
                                            ->where('course_code', $this->data['course']->course_code)
                                            ->where('course_year_code', $this->data['course_year_code'])
                                            ->get();

        return View::make('admin.subjectschedule.setschedules.index', $this->data);
    }

    public function postAddSubject()
    {
        $is_found = CourseSubject::where('school_year', Input::get('school_year'))
            ->where('semester', Input::get('semester'))
            ->where('course_code', Input::get('course_code'))
            ->where('course_year_code', Input::get('course_year_code'))
            ->where('subject_code', Input::get('subject_code'))
            ->first();

        if (!$is_found)
        {
            $course_subject = new CourseSubject();
            $course_subject->school_year = Input::get('school_year');
            $course_subject->semester = Input::get('semester');
            $course_subject->course_code = Input::get('course_code');
            $course_subject->course_year_code = Input::get('course_year_code');
            $course_subject->subject_code = Input::get('subject_code');
            $course_subject->save();
        }

        return Redirect::to(admin_url('/subject-schedules/set-schedules'))
            ->with(SUCCESS_MESSAGE, 'Successfully added subject.');
    }

    public function getRemoveSubject()
    {
        CourseSubject::where('id', Input::get('course_subject_id'))->delete();

        return Redirect::to(admin_url('/subject-schedules/set-schedules'))
            ->with(SUCCESS_MESSAGE, 'Successfully deleted subject.');
    }

    public function postAddSchedule()
    {
        # CourseSubjectSchedule::where('id', not)

        $timestamp_time_start = strtotime('1970-01-01 '.Input::get('time_start'));
        $timestamp_time_end = strtotime('1970-01-01 '.Input::get('time_end'));
        if ($timestamp_time_start > $timestamp_time_end)
        {
            $timestamp_time_end = strtotime('1970-01-02 '.Input::get('time_end'));
        }

        $has_returned_message = has_schedule_conflict(Input::get('days', array()), $timestamp_time_start, $timestamp_time_end, Input::get('room_id'));
        if ($has_returned_message)
        {
            return Response::json(array(
                'status' => RESULT_FAILURE,
                'message' => $has_returned_message,
            ));
        }

        // check if has conflicts
        $model = new CourseSubjectSchedule();
        $model->course_subject_id = Input::get('course_subject_id');
        $model->room_id = Input::get('room_id');
        $model->instructor_id = Input::get('instructor_id');
        $model->time_start = date('Y-m-d H:i:s', $timestamp_time_start);
        $model->time_end = date('Y-m-d H:i:s', $timestamp_time_end);
        $flipped = array_flip(Input::get('days', array()));
        $model->day_mon = isset($flipped['day_mon']);
        $model->day_tue = isset($flipped['day_tue']);
        $model->day_wed = isset($flipped['day_wed']);
        $model->day_thu = isset($flipped['day_thu']);
        $model->day_fri = isset($flipped['day_fri']);
        $model->day_sat = isset($flipped['day_sat']);
        $model->day_sun = isset($flipped['day_sun']);
        $model->save();

        Session::flash(SUCCESS_MESSAGE, 'Successfully added schedule.');
//        'days' =>
//  array (
//      0 => 'day_tue',
//      1 => 'day_wed',
//      2 => 'day_sat',
//  ),
//  'room_id' => 'RM-01',
//  'instructor_id' => 'INS-230708',
//  'hour' => '07',
//  'minute' => '00',
//  'meridian' => 'AM',
//  'time_start' => '07:00 AM',
//  'time_end' => '07:00 AM',
//  'course_subject_id' => '2',
//        echo '<pre><dd>'.var_export(Input::all(), true).'</dd></pre>';
//        die();
//        $ret = array(
//            'status' => RESULT_FAILURE,
//            'message' => 'Time Conflicts with',
//        );
        return Response::json(array(
            'status' => RESULT_SUCCESS,
        ));
    }


    public function getRemoveSchedule()
    {
        CourseSubjectSchedule::where('id', Input::get('course_subject_schedule_id'))->delete();

        return Redirect::to(admin_url('/subject-schedules/set-schedules'))
            ->with(SUCCESS_MESSAGE, 'Successfully deleted subject schedule.');
    }
}
