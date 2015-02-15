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

    public function postAddUpdateSchedule()
    {
        # CourseSubjectSchedule::where('id', not)

        // if edit,
        $course_subject_schedule = CourseSubjectSchedule::find(Input::get('course_subject_schedule_id', 0));

        $timestamp_time_start = strtotime('1970-01-01 '.Input::get('time_start'));
        $timestamp_time_end = strtotime('1970-01-01 '.Input::get('time_end'));

        // time start and end should not equal
        if ($timestamp_time_start == $timestamp_time_end)
        {
            return Response::json(array(
                'status' => RESULT_FAILURE,
                'message' => 'Start time and end time should not the same.',
            ));
        }

        // if time start is greater than time end, then
        // it is a next day time, (i.e 11:00 pm to 2:00 am)
        if ($timestamp_time_start > $timestamp_time_end)
        {
            $timestamp_time_end = strtotime('1970-01-02 '.Input::get('time_end'));
        }

        // We need to check if has conflict with has schedule conflict method.
        // has_schedule_conflict return true then it is the html error message,
        // else then continue
        $has_returned_message = has_schedule_conflict(Input::get('days', array()), $timestamp_time_start, $timestamp_time_end, Input::get('room_id'), ($course_subject_schedule ? $course_subject_schedule : NULL));
        if ($has_returned_message)
        {
            return Response::json(array(
                'status' => RESULT_FAILURE,
                'message' => $has_returned_message,
            ));
        }

        // save data entry to database
        $model = $course_subject_schedule ? $course_subject_schedule : new CourseSubjectSchedule();
        $model->course_subject_id       = Input::get('course_subject_id');
        $model->room_id                 = Input::get('room_id');
        $model->instructor_id           = Input::get('instructor_id');
        $model->time_start              = date('Y-m-d H:i:s', $timestamp_time_start);
        $model->time_end                = date('Y-m-d H:i:s', $timestamp_time_end);

        // we need to flipped the days, so we can use isset function easily
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

        return Response::json(array(
            'status' => RESULT_SUCCESS,
        ));
    }

    public function getFormEditSchedule()
    {
        $course_subject_schedule = CourseSubjectSchedule::find(Input::get('course_subject_schedule_id'));

        if ($course_subject_schedule)
        {
            $this->data['course_subject_schedule'] = $course_subject_schedule;
            $this->data['course_subject'] = $course_subject_schedule->courseSubject;

            return array(
                'status' => RESULT_SUCCESS,
                'html' => View::make('admin.subjectschedule.setschedules._edit_schedule_form')->with($this->data)->render()
            );
        }

        return array(
            'status' => RESULT_FAILURE,
            'message' => 'Schedule id not found.'
        );
    }

    public function getRemoveSchedule()
    {
        CourseSubjectSchedule::where('id', Input::get('course_subject_schedule_id'))->delete();

        return Redirect::to(admin_url('/subject-schedules/set-schedules'))
            ->with(SUCCESS_MESSAGE, 'Successfully deleted subject schedule.');
    }
}
