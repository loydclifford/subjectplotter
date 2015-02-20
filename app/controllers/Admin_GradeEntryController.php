<?php

class Admin_GradeEntryController extends BaseController {

    public function getIndex()
    {
        // Lists
        $list = new GradeEntryTblist();
        $list->prepareList();

        if (Request::ajax())
        {
            return $list->toJson();
        }

        $this->data['meta']->title = lang('gradeentry/texts.meta_title');
        $this->data['list']        = $list;
        $this->data['list_action'] = '#';

        return View::make('admin.grade-entry.index', $this->data);
    }

    public function getView(Student $student)
    {
        $studentPlotting = StudentPlotting::getLatestPlotting($student);

        if ($studentPlotting)
        {
            $this->data['meta']->title  = 'Student Plotting Request';

            $this->data['student_plotting']  = $studentPlotting;
            $this->data['student']  = $studentPlotting->student;
            $this->data['course_code']  = $studentPlotting->course_code;
            $this->data['course_year_code']  = $studentPlotting->course_year_code;
            $this->data['semester']  = $studentPlotting->semester == 'first_semester' ? 'First Semester' : 'Second Semester';

            $this->data['student_subjects'] = StudentSubject::where('student_plotting_id', $studentPlotting->id)->get();

            return View::make('admin.grade-entry.view', $this->data);
        }
        else
        {
            $this->data['student']  = $student;
            return View::make('admin.grade-entry.view_no_plotting', $this->data);
        }
    }

    public function postView(Student $student)
    {
        foreach (Input::get('average', array()) as $student_subject_id =>$average)
        {
            $student_subject = StudentSubject::find($student_subject_id);
            if ($student_subject)
            {
                $student_subject->average = $average;
                $student_subject->save();
            }
        }

        return Redirect::back()->with(SUCCESS_MESSAGE, 'Successfully updated grade.');
    }
}
