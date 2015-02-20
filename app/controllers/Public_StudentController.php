<?php

class Public_StudentController extends BaseController {

	public function getIndex()
	{
		$this->data['meta']->title = 'Student Dashboard';
		$this->data['active_menu'] = 'dashboard';

		$this->data['course_subjects'] = CourseSubject::where('school_year', get_current_school_year())
				->where('course_code', user_get()->student->course_code)
				->where('course_year_code', user_get()->student->course_year_code)
				->where('semester', 'first_semester')
				->get();

		return View::make('public.student.dashboard', $this->data);
	}

	public function getAccount()
	{
		$this->data['meta']->title = 'Student Account';
		$this->data['active_menu'] = 'accounts';

		// form data
		$this->data['url']         = URL::current();
		$this->data['method']      = 'POST';
		$this->data['return_url']  = URL::current();
		$this->data['success_url'] = URL::current();

		$this->data['student']     	= user_get()->student;
		$this->data['student_user']	= $this->data['student']->user;

		return View::make('public.student.account', $this->data);
	}

	public function postAccount()
	{
		// Check for taxonomy slugs
		$student_repo  = new StudentForm(user_get()->student);
		if ($has_error = $student_repo->validateInput())
		{
			return $has_error;
		}

		$student = $student_repo->saveInput();
		Event::fire('student.update', $student);

		return Redirect::back()
			->with(SUCCESS_MESSAGE, 'Successfully updated account info.');
	}
}
