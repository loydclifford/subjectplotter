<?php

class StudentPlotting extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_plotting';
    protected $primaryKey = 'id';

    public $timestamps = false;

    const STATUS_PLOTTING = 'plotting';
    const STATUS_PLOTTED = 'plotted';
    const STATUS_APPROVED = 'approved';

}
