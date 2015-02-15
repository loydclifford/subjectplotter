<?php

class Course extends Eloquent {

    // Presenter
    use PresentableTrait;
    protected $presenter = 'CoursePresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';
    protected $primaryKey = 'course_code';
    public $incrementing = false;
    public $timestamps = false;

    public function courseYear()
    {
        return $this->hasMany('CourseYear', 'course_code')->orderBy('course_year_order', 'asc');
    }
}
