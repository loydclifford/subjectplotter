<?php

class CourseSubjectSchedule extends Eloquent {

    // Presenter
    use PresentableTrait;
    protected $presenter = 'CourseSubjectSchedulePresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'course_subject_schedules';
    protected $primaryKey = 'id';

    public $timestamps = false;

    public function courseSubject()
    {
        return $this->belongsTo('CourseSubject', 'course_subject_id', 'id');
    }

    public function instructor()
    {
        return $this->belongsTo('Instructor', 'instructor_id', 'id');
    }

    public function room()
    {
        return $this->belongsTo('Room', 'room_id', 'room_id');
    }

    public static function getDataPresetByCourseSubjectId($course_subject_id)
    {
        $ret = CourseSubjectSchedule::leftJoin('course_subjects', 'course_subjects.id', '=','course_subject_schedules.course_subject_id')
            ->leftJoin('instructors', 'instructors.id', '=', 'course_subject_schedules.instructor_id')
            ->leftJoin('users', 'users.id', '=', 'instructors.user_id')
            ->leftJoin('rooms', 'rooms.room_id', '=', 'course_subject_schedules.room_id')
            ->select(
                'course_subject_schedules.*',
                'users.first_name as user_first_name',
                'users.last_name as user_last_name',
                'rooms.room_capacity'
            )
            ->where('course_subject_id', $course_subject_id)
            ->get();
        return $ret;
    }
}
