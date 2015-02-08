<?php

class CourseSubject extends Eloquent {

    // Presenter
    use PresentableTrait;
    protected $presenter = 'CourseSubjectPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'course_subjects';
    protected $primaryKey = 'id';

    public $timestamps = false;

    public function subject()
    {
        return $this->belongsTo('Subject', 'subject_code', 'subject_code');
    }

    public function courseSubjectSchedules()
    {
        return $this->hasMany('CourseSubjectSchedule', 'course_subject_id', 'id');
    }
}
