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
    const STATUS_DENIED = 'denied';

    public static $statuses = array(
        self::STATUS_APPROVED => self::STATUS_APPROVED,
        self::STATUS_PLOTTED => self::STATUS_PLOTTED,
        self::STATUS_DENIED => self::STATUS_DENIED,
    );

    public function student()
    {
        return $this->hasOne('Student', 'student_no', 'student_no');
    }

    public static function getLatestPlotting(Student $student)
    {
        return StudentPlotting::where('student_no', $student->student_no)
            ->orderBy('id', 'asc')
            ->first();
    }
}
