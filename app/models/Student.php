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

    public $timestamps = true;

    public static $gender = array(
        'male'   => 'Male',
        'female' => 'Female',
    );

    public static $year = array(
        'I'   => 'I',
        'II'  => 'II',
        'III' => 'III',
        'IV'  => 'IV',
    );

    public function user()
    {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public static function getAges(){

        $ret = array();
        for($i=1; $i<=100; $i++)
        {
            $ret[$i] = $i;
        }

        return $ret;
    }

    public static function generateStudentNo()
    {
        $newId = NULL;

        while ($newId == NULL)
        {
            $newIdVal = rand(99999,9999939);
            $hasExists = Student::where('student_no', $newIdVal)->count();
            if ($hasExists) $newId = NULL;
            else $newId = $newIdVal;
        }

        return $newId;
    }

    public static function checkSchedule($subject_id)
    {
        return $subject_id;
    }
}
