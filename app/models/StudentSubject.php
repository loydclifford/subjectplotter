<?php

class StudentSubject extends Eloquent {

    // Presenter
    use PresentableTrait;
    protected $presenter = 'StudentSubjectsPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_subjects';
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * Return array of subject schedule id that the student has taken to
     *
     * @param $student_no
     * @param $school_year
     * @param $course_code
     * @param $course_year_code
     * @param string $semester
     * @return array
     */
    public static function getCourseSubjectScheduleId($student_no, $school_year, $course_code, $course_year_code, $semester = 'first_semester')
    {
        $student_schedule = StudentSubject::where('school_year', $school_year)
            ->where('course_code', $course_code)
            ->where('course_year_code', $course_year_code)
            ->where('semester', $semester)
            ->where('student_no', $student_no)
            ->get();

        if (!count($student_schedule))
        {
            self::doLoadDefaultSchedule($student_no, $school_year, $course_code, $course_year_code, $semester);

            return self::getCourseSubjectScheduleId($student_no, $school_year, $course_code, $course_year_code, $semester);
        }
        else
        {
            return $student_schedule->lists('course_subject_schedule_id');
        }
    }

    public static function doLoadDefaultSchedule($student_no, $school_year, $course_code, $course_year_code, $semester = 'first_semester')
    {
        $course_subjects = CourseSubject::where('school_year', $school_year)
            ->where('course_code', $course_code)
            ->where('course_year_code', $course_year_code)
            ->where('semester', $semester)
            ->get();

        StudentSubject::where('school_year', $school_year)
            ->where('course_code', $course_code)
            ->where('course_year_code', $course_year_code)
            ->where('semester', $semester)
            ->delete();

        foreach ($course_subjects as $course_subject)
        {
            $student_subject = new StudentSubject();
            $student_subject->school_year = $school_year;
            $student_subject->semester = $semester;
            $student_subject->course_code =  $course_code;
            $student_subject->course_year_code =  $course_year_code;

            $student_subject->student_no = $student_no;
            $student_subject->course_subject_id = $course_subject->id;

            // which subject schedules this user to set
            foreach (CourseSubjectSchedule::getDataPresetByCourseSubjectId($course_subject->id) as $course_subject_schedule)
            {
                $student_subject->course_subject_schedule_id = $course_subject_schedule->id;

                // if room capacity for current schedule has been occ
                if (StudentSubject::where('course_subject_schedule_id', $course_subject_schedule->id)->count() <= $course_subject_schedule->room->room_capacity)
                {
                    break;
                }
            }

            $student_subject->average = 0;
            $student_subject->status = StudentPlotting::STATUS_PLOTTING;
            $student_subject->save();
        }
    }
}
