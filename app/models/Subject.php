<?php

class Subject extends Eloquent {

    // Presenter
    use PresentableTrait;
    protected $presenter = 'SubjectPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table      = 'subjects';
    protected $primaryKey = 'subject_code';

    public $timestamps    = false;

}
