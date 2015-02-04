<?php

class Instructor extends Eloquent {

    // Presenter
    use PresentableTrait;
    protected $presenter = 'InstructorPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'instructors';
    protected $primaryKey = 'instructor_id';

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function instructorSubjectCategories()
    {
        return $this->hasMany('InstructorSubjectCategory', 'instructor_id', 'id');
    }
}
