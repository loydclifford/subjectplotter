<?php

class Admin_SubjectRequestController extends BaseController {

    /**
     * General
     *
     * @return \Illuminate\View\View|string
     */
    public function getIndex()
    {
        // Lists
        $list = new SubjectRequestTblist();
        $list->prepareList();

        if (Request::ajax())
        {
            return $list->toJson();
        }

        $this->data['meta']->title  = 'Student Plotting Request';
        $this->data['list']         = $list;
        $this->data['list_action']  = '#';

        return View::make('admin.schedule_request.index', $this->data);
    }

    public function getView(StudentPlotting $studentPlotting)
    {
        $this->data['meta']->title  = 'Student Plotting Request';

        $this->data['student_plotting']  = $studentPlotting;
        $this->data['student']  = $studentPlotting->student;
        $this->data['course_code']  = $studentPlotting->course_code;
        $this->data['course_year_code']  = $studentPlotting->course_year_code;
        $this->data['semester']  = $studentPlotting->semester == 'first_semester' ? 'First Semester' : 'Second Semester';

        $course_subject_schedule_id = StudentSubject::where('student_plotting_id', $studentPlotting->id)->get()->lists('course_subject_schedule_id');

        $this->data['course_subject_schedules'] = CourseSubjectSchedule::whereIn('id',$course_subject_schedule_id )->get();

        return View::make('admin.schedule_request.view', $this->data);

    }

    public function getApprove(StudentPlotting $studentPlotting)
    {
        $studentPlotting->status = StudentPlotting::STATUS_APPROVED;
        $studentPlotting->save();

        return Redirect::back()->with(SUCCESS_MESSAGE, 'Successfully approved plotting.');
    }

    public function getDeny(StudentPlotting $studentPlotting)
    {
        $studentPlotting->status = StudentPlotting::STATUS_DENIED;
        $studentPlotting->save();

        return Redirect::back()->with(SUCCESS_MESSAGE, 'Successfully denied plotting.');
    }
}
