<?php

class Student extends Eloquent {

    // Presenter
    use PresentableTrait;
    protected $presenter = 'StudentPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table      = 'students';
    protected $primaryKey = 'student_no';

    public $timestamps = false;
}
