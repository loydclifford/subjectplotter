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

    // Static Helpers
    public static function generateNewId()
    {
        $newId = NULL;

        while ($newId == NULL)
        {
            $newIdVal = 'SUB-'.rand(99999,999999);
            $hasExists = Subject::where('id', $newIdVal)->count();
            if ($hasExists) $newId = NULL;
            else $newId = $newIdVal;
        }

        return $newId;
    }
}
