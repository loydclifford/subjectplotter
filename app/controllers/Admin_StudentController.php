<?php

class Admin_StudentController extends BaseController {

    public function getIndex()
    {
        // Lists
        $list = new StudentTblist();
        $list->prepareList();

        if (Request::ajax())
        {
            return $list->toJson();
        }

        $this->data['meta']->title = lang('student/texts.meta_title');
        $this->data['list']        = $list;
        $this->data['list_action'] = '#';

        return View::make('admin.student.index', $this->data);
    }

    public function getCreate()
    {
        // Meta Data
        $this->data['meta']->title = lang('student/texts.create_meta_title');
        $this->data['page_title']  = lang('student/texts.create_page_title');

        // Form data
        $this->data['url']         = URL::current();
        $this->data['method']      = 'POST';
        $this->data['return_url']  = admin_url('/students/create');
        $this->data['success_url'] = admin_url('/students');

        $this->data['generated_student_no'] = Student::generateStudentNo();

        return View::make('admin.student.create_edit')->with($this->data);
    }

    public function postCreate()
    {
        // Check for taxonomy slugs
        $student_repo  = new StudentForm(new Student());
        if ($has_error = $student_repo->validateInput())
        {
            return $has_error;
        }

        $student = $student_repo->saveInput();
        Event::fire('student.add', $student);

        return Redirect::to(Input::get('_success_url'))
            ->with(SUCCESS_MESSAGE,lang('student/texts.create_success'));
    }

    public function getEdit(Student $student)
    {
        $this->data['meta']->title = lang('student/texts.update_meta_title');
        $this->data['page_title']  = lang('student/texts.update_page_title');

        $this->data['url']         = URL::current();
        $this->data['method']      = 'POST';
        $this->data['return_url']  = admin_url("/students/{$student->student_no}/edit");
        $this->data['success_url'] = admin_url("/students/{$student->student_no}/edit");

        $this->data['enable_breadcrumb'] = false;
        $this->data['student']           = $student;
        $this->data['student_user']      = $student->user;

        return View::make('admin.student.create_edit')->with($this->data);
    }

    public function postEdit(Student $student)
    {
        // Check for taxonomy slugs
        $student_repo  = new StudentForm($student);
        if ($has_error = $student_repo->validateInput())
        {
            return $has_error;
        }

        $student = $student_repo->saveInput();
        Event::fire('student.update', $student);

        return Redirect::to(admin_url("/students/{$student->student_no}/edit"))
            ->with(SUCCESS_MESSAGE,lang('student/texts.update_success'));
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

            $course_subject_schedule_id = StudentSubject::where('student_plotting_id', $studentPlotting->id)->get()->lists('course_subject_schedule_id');

            $this->data['course_subject_schedules'] = CourseSubjectSchedule::whereIn('id',$course_subject_schedule_id )->get();

            return View::make('admin.student.view', $this->data);
        }
        else
        {
            $this->data['student']  = $student;
            return View::make('admin.student.view_no_plotting', $this->data);
        }
    }

    public function getDelete()
    {
        Utils::validateBulkArray('user_id');

        // The student id
        $user_ids = Input::get('user_id', array());
        $students = Student::whereIn('student_no', $user_ids)->delete();

        // Delete Students
         Event::fire('student.delete', $students);

        if (Input::has('_success_url'))
        {
            return Redirect::to(Input::get('_success_url'))
                ->with(SUCCESS_MESSAGE, lang('student/texts.delete_success'));
        }
        else
        {
            return Redirect::back()
                ->with(SUCCESS_MESSAGE, lang('student/texts.delete_success'));
        }
    }

    // Import
    public function getExport()
    {
        Utils::validateBulkArray('user_id');

        $array = Student::whereIn('user_id',Input::get('user_id'))->get()->toArray();

        // Start export if not empty
        if ( ! empty($array))
        {
            $headers = array_keys($array[0]);
            Utils::csvDownload('students_data_csv', $array, $headers);
        }
    }
}
