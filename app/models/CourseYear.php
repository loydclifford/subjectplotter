<?php

class CourseYear extends Eloquent {

    // Presenter
    use PresentableTrait;
    protected $presenter = 'CourseYearPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'course_years';
    protected $primaryKey = 'id';

    public $timestamps = false;
}
