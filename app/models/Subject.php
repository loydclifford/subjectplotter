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
    use UserTrait;

    const STATUS_ACTIVE     = 'Active';
    const STATUS_INACTIVE   = 'Inactive';

    public static $units = array(
        self::STATUS_ACTIVE     => self::STATUS_ACTIVE,
        self::STATUS_INACTIVE   => self::STATUS_INACTIVE
    );


    protected $table      = 'subjects';
    protected $primaryKey = 'subject_code';

    public $timestamps    = false;

}
