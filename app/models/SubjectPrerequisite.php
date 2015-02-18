<?php

class SubjectPrerequisite extends Eloquent {

    // Presenter
    use PresentableTrait;
    protected $presenter = 'SubjectPrerequisitePresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table      = 'subject_prerequisites';
    protected $primaryKey = 'subject_code';

    public $incrementing = false;
    public $timestamps    = false;


}
