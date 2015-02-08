<?php

class SubjectScheduleController extends BaseController {

    /**
     * General
     *
     * @return \Illuminate\View\View|string
     */
    public function getIndex()
    {
        // Lists
        $this->data['meta']->title  = lang('subjectschedule/texts.page_title');
        $this->data['page_title']  = lang('subjectschedule/texts.page_title');
        $this->data['current_tab']  = 'general';

        return View::make('admin.subjectschedule.index', $this->data);
    }

    public function postIndex()
    {
        Session::put('selected_school_year', Input::get('school_year'));
        Session::put('selected_course_code', Input::get('course_code'));

        return Redirect::to(admin_url('/subject-schedules/set-schedules'));
    }
}