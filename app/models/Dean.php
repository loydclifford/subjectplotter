<?php

class Dean extends Eloquent
{

    // Presenter
    use PresentableTrait;
    protected $presenter = 'DeanPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'deans';
    protected $primaryKey = 'id';

    public $incrementing = false;
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne('User', 'id', 'user_id');
    }

    public function subjectCategory()
    {
        return $this->belongsToMany('SubjectCategory', 'dean_subject_categories', 'dean_id', 'subject_category_code');
    }

    // Static Helpers
    public static function generateNewId()
    {
        $newId = NULL;

        while ($newId == NULL)
        {
            $newIdVal = 'INS-'.rand(99999,999999);
            $hasExists = Dean::where('id', $newIdVal)->count();
            if ($hasExists) $newId = NULL;
            else $newId = $newIdVal;
        }

        return $newId;
    }

    public static function getDeanBySubjectCategory($subject_category_code)
    {
        return Dean::leftJoin('dean_subject_categories', 'dean_subject_categories.dean_id','=','deans.id')
            ->leftJoin('users', 'users.id','=','deans.user_id')
            ->where('dean_subject_categories.subject_category_code', $subject_category_code)
            ->select('dean_subject_categories.*', DB::raw('concat(users.first_name, " ", users.last_name) as full_name'))
            ->get();
    }
}
