<?php

class Instructor extends Eloquent
{

    // Presenter
    use PresentableTrait;
    protected $presenter = 'InstructorPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'instructors';
    protected $primaryKey = 'id';

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function subjects()
    {
        return $this->belongsToMany('SubjectCategory', 'instructor_subject_categories', 'instructor_id', 'subject_category_code');
    }

    // Static Helpers
    public static function generateNewId()
    {
        $newId = NULL;

        while ($newId == NULL)
        {
            $newIdVal = 'INS-'.rand(99999,999999);
            $hasExists = Instructor::where('id', $newIdVal)->count();
            if ($hasExists) $newId = NULL;
            else $newId = $newIdVal;
        }

        return $newId;
    }
}
