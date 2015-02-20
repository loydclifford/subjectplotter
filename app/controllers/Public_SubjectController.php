<?php

class Public_SubjectController extends BaseController {

	public function getSearchSelect()
	{
		if (Input::has('method') && Input::get('method') == "init-selection"){
			$course_subject_schedule = CourseSubjectSchedule::find(Input::get('id'));

			$course_subject = $course_subject_schedule->courseSubject;

			if($course_subject)
			{
				$ret['id']                = $course_subject_schedule->id;
				$ret['name']              = $course_subject->subject->subject_name;
				$ret['course_year']       = $course_subject->course_code . '-'. $course_subject->course_year_code;
				$ret['descriptive_title'] = $course_subject->subject->description;
				$ret['day']               = $course_subject_schedule->present()->getDayString();
				$ret['time']              = $course_subject_schedule->present()->getTimeSchedule();
				$ret['room']              = $course_subject_schedule->room_id;
				$ret['units']             = $course_subject->subject->units;
				$ret['instructor_name']   = $course_subject_schedule->instructor->first_name . ' ' . $course_subject_schedule->instructor->last_name;
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
		$course_subject_schedule = CourseSubjectSchedule::select(DB::raw('course_subject_schedules.*,
					  subjects.subject_name,
					  users.first_name AS instructor_first_name,
					  users.last_name AS instructor_last_name,
					  subjects.subject_name AS subject_name,
					  subjects.description AS description'))
			->leftJoin('course_subjects', 'course_subjects.id', '=', 'course_subject_schedules.course_subject_id')
			->leftJoin('subjects', 'subjects.subject_code', '=', 'course_subjects.subject_code')
			->leftJoin('instructors', 'instructors.id', '=', 'course_subject_schedules.instructor_id')
			->leftJoin('users', 'users.id', '=', 'instructors.user_id')
			->where('course_subjects.subject_code', 'LIKE', '%'.$queue.'%')
			->orWhere('course_subject_schedules.room_id', 'LIKE', '%'.$queue.'%')
			->orWhere('subjects.subject_name', 'LIKE', '%'.$queue.'%')
			->orWhere('subjects.description', 'LIKE', '%'.$queue.'%')
			->orWhere('users.first_name', 'LIKE', '%'.$queue.'%')
			->orWhere('users.last_name', 'LIKE', '%'.$queue.'%');

		$results = $course_subject_schedule->skip($offset)
			->take($per_page)
			->get();

		$ret = array(
			'total' => $course_subject_schedule->count()
		);

		$subjects_assoc = array();
		foreach($results as $subject) {
			$str = array();

			if ($subject->day_mon) $str[] = 'Mon';
			if ($subject->day_tue) $str[] = 'Tue';
			if ($subject->day_wed) $str[] = 'Wed';
			if ($subject->day_thu) $str[] = 'Thu';
			if ($subject->day_fri) $str[] = 'Fri';
			if ($subject->day_sat) $str[] = 'Sat';
			if ($subject->day_sun) $str[] = 'Sun';

			$day = join('-',$str);

			$subjects_assoc[] = array(
				'id'                => $subject->id,
				'name'              => $subject->subject_name,
				'course_year'       => $subject->course_code . '-' .$subject->course_year_code,
				'descriptive_title' => $subject->description,
				'day'               => $day,
				'time'              => $subject->time_start . '-' . $subject->time_end,
				'room'              => $subject->room_id,
				'units'             => $subject->units,
				'instructor_name'   => $subject->first_name . ' ' . $subject->last_name,
			);
		}

		$ret['subjects'] = $subjects_assoc;

		return Response::json($ret);
	}


}
