<?php

class GradeEntry extends Eloquent {

    // Presenter
    use PresentableTrait;
    protected $presenter = 'GradeEntryPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table      = 'subjects';
    protected $primaryKey = 'subject_code';

    public $incrementing = false;
    public $timestamps    = false;

    public static $units = array(
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
    );

    public function subjectPrequisites()
    {
        return $this->hasMany('SubjectPrerequisite', 'subject_code', 'subject_code');
    }

    // Static Helpers
    public static function generateNewId()
    {
        $newId = NULL;

        while ($newId == NULL)
        {
            $newIdVal = 'SUB-'.rand(99999,999999);
            $hasExists = Subject::where('subject_code', $newIdVal)->count();
            if ($hasExists) $newId = NULL;
            else $newId = $newIdVal;
        }

        return $newId;
    }

    public static function getSubjects(array $exclude = array())
    {
        if (empty($exclude))
        {
            $query = self::all();
        }
        else
        {
            $query = self::whereNotIn('subject_code', $exclude);
        }

        return $query->lists('subject_name', 'subject_code');
    }
}
