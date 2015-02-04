<?php

class StudentSubjects extends Eloquent {

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
}
