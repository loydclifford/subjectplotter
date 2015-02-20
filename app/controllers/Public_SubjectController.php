<?php

class Public_SubjectController extends BaseController {

	public function getRemove()
	{
		StudentSubject::where('course_subject_schedule_id', Input::get('course_subject_schedule_id', 0))->delete();

		return Redirect::to('/dashboard')->with(SUCCESS_MESSAGE, 'Successfully removed subject.');
	}

	public function postSubmitPlotting()
	{


		$student_schedules = StudentSubject::where('school_year', Input::get('school_year'))
			->where('course_code', Input::get('course_code'))
			->where('course_year_code', Input::get('course_year_code'))
			->where('semester', Input::get('semester'))
			->where('student_no', Input::get('student_no'))
			->get();



		$student_plotting = new StudentPlotting();
		$student_plotting->student_no = Input::get('student_no');
		$student_plotting->school_year = Input::get('school_year');
		$student_plotting->semester = Input::get('semester');
		$student_plotting->course_code = Input::get('course_code');
		$student_plotting->course_year_code = Input::get('course_year_code');
		$student_plotting->status = StudentPlotting::STATUS_PLOTTED;
		$student_plotting->save();

		foreach ($student_schedules as $student_schedule)
		{
			$student_schedule->status = StudentPlotting::STATUS_PLOTTED;
			$student_schedule->student_plotting_id = $student_plotting->id;
			$student_schedule->save();
		}

		return Redirect::to('/dashboard')->with(SUCCESS_MESSAGE, 'Successfully plotted subjects.');
	}

	public function postAddSubject()
	{
		$course_subject_schedule = CourseSubjectSchedule::find(Input::get('course_subject_schedule_id', 0));

		if ($course_subject_schedule)
		{

			$student_course_subject_schedule_ids = StudentSubject::getCourseSubjectScheduleId(
				Input::get('student_no'),
				Input::get('school_year'),
				Input::get('course_code'),
				Input::get('course_year_code'),
				Input::get('semester')
			);

			$course_subject_schedules = CourseSubjectSchedule::whereIn('id', $student_course_subject_schedule_ids)->get();

			$total_units = 0;

			foreach ($course_subject_schedules as $course_subject_schedule)
			{
				$total_units += $course_subject_schedule->courseSubject->subject->units;
			}

			$max_units = Subject::countUnits(
				Input::get('school_year'),
				Input::get('course_code'),
				Input::get('course_year_code')
			);

			if ($max_units < $total_units)
			{
				return Redirect::back()->with(ERROR_MESSAGE, 'Invalid entry. You reached the maximum units.');
			}

			$student_subject = new StudentSubject();
			$student_subject->school_year = Input::get('school_year');
			$student_subject->semester = Input::get('semester');
			$student_subject->course_code =  Input::get('course_code');
			$student_subject->course_year_code =  Input::get('course_year_code');

			$student_subject->student_no = Input::get('student_no');
			$student_subject->course_subject_schedule_id = $course_subject_schedule->id;
			$student_subject->course_subject_id = $course_subject_schedule->course_subject_id;

			$student_subject->average = 0;
			$student_subject->status = StudentPlotting::STATUS_PLOTTING;
			$student_subject->save();
		}

		return Redirect::to('/dashboard')->with(SUCCESS_MESSAGE, 'Successfully added subject.');
	}

	public function getLoadDefaults()
	{
		StudentSubject::doLoadDefaultSchedule(
			user_get()->student->student_no,
			get_current_school_year(),
			user_get()->student->course_code,
			user_get()->student->course_year_code,
			'first_semester'
		);

		return Redirect::to('/dashboard')->with(SUCCESS_MESSAGE, 'Successfully loaded default subjects.');
	}

	public function getSearchSelect()
	{
		if (Input::has('method') && Input::get('method') == "init-selection"){
			$course_subject_schedules = CourseSubjectSchedule::find(Input::get('id'));

			$course_subject = $course_subject_schedules->courseSubject;

			if($course_subject)
			{
				$ret['id']                = $course_subject_schedules->id;
				$ret['name']              = $course_subject->subject->subject_name;
				$ret['course_year']       = $course_subject->course_code . '-'. $course_subject->course_year_code;
				$ret['descriptive_title'] = $course_subject->subject->description;
				$ret['day']               = $course_subject_schedules->present()->getDayString();
				$ret['time']              = $course_subject_schedules->present()->getTimeSchedule();
				$ret['room']              = $course_subject_schedules->room_id;
				$ret['units']             = $course_subject->subject->units;
				$ret['instructor_name']   = $course_subject_schedules->instructor->first_name . ' ' . $course_subject_schedules->instructor->last_name;
				return Response::json($ret);
			}

			return Response::json(array());
		}

		$per_page   = Input::get('per_page', 2);
		$page       = Input::get('page', 1);
		$offset     = ($page - 1 ) * $per_page;
		$queue      = trim(Input::get('q'));

		// generate the query
		// If string, then it is a name that the user is
		// intended to search
		$course_subject_schedules = CourseSubjectSchedule::select(DB::raw('course_subject_schedules.*,
					  subjects.subject_name,
					  subjects.units,
					  course_subjects.course_code,
					  course_subjects.course_year_code,
					  users.first_name AS instructor_first_name,
					  users.last_name AS instructor_last_name,
					  subjects.subject_name AS subject_name,
					  subjects.description AS description'))
			->leftJoin('course_subjects', 'course_subjects.id', '=', 'course_subject_schedules.course_subject_id')
			->leftJoin('subjects', 'subjects.subject_code', '=', 'course_subjects.subject_code')
			->leftJoin('instructors', 'instructors.id', '=', 'course_subject_schedules.instructor_id')
			->leftJoin('users', 'users.id', '=', 'instructors.user_id')
			->where(function($query) use ($queue) {
				$query->where('course_subjects.subject_code', 'LIKE', '%'.$queue.'%')
					->orWhere('course_subject_schedules.room_id', 'LIKE', '%'.$queue.'%')
					->orWhere('subjects.subject_name', 'LIKE', '%'.$queue.'%')
					->orWhere('subjects.description', 'LIKE', '%'.$queue.'%')
					->orWhere('users.first_name', 'LIKE', '%'.$queue.'%')
					->orWhere('users.last_name', 'LIKE', '%'.$queue.'%');
			});

		$excluded_id = explode(',', Input::get('exclude_course_subject_schedules_id', ''));

		if (count($excluded_id))
		{
			$course_subject_schedules->whereNotIn('course_subject_schedules.id', $excluded_id);
		}

		$results = $course_subject_schedules->skip($offset)
			->take($per_page)
			->get();

		$ret = array(
			'total' => $course_subject_schedules->count()
		);

		$subjects_assoc = array();
		foreach($results as $course_subject_schedule) {
			$str = array();

			if ($course_subject_schedule->day_mon) $str[] = 'Mon';
			if ($course_subject_schedule->day_tue) $str[] = 'Tue';
			if ($course_subject_schedule->day_wed) $str[] = 'Wed';
			if ($course_subject_schedule->day_thu) $str[] = 'Thu';
			if ($course_subject_schedule->day_fri) $str[] = 'Fri';
			if ($course_subject_schedule->day_sat) $str[] = 'Sat';
			if ($course_subject_schedule->day_sun) $str[] = 'Sun';

			$day = join('-',$str);

			$formatted_start_time = date('h:i a', strtotime($course_subject_schedule->time_start));
			$formatted_end_time = date('h:i a', strtotime($course_subject_schedule->time_end));
			$time = $formatted_start_time . ' - ' . $formatted_end_time;

			$subjects_assoc[] = array(
				'id'                => $course_subject_schedule->id,
				'name'              => $course_subject_schedule->subject_name,
				'course_year'       => $course_subject_schedule->course_code . '-' .$course_subject_schedule->course_year_code,
				'descriptive_title' => $course_subject_schedule->description,
				'day'               => $day,
				'time'              => $time,
				'room'              => $course_subject_schedule->room_id,
				'units'             => $course_subject_schedule->units,
				'instructor_name'   => $course_subject_schedule->instructor_first_name . ' ' . $course_subject_schedule->instructor_last_name,
			);
		}

		$ret['subjects'] = $subjects_assoc;

		return Response::json($ret);
	}





}
