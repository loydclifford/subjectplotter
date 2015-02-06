<?php

class SubjectCategory extends Eloquent {

    // Presenter
    use PresentableTrait;
    protected $presenter = 'SubjectCategoriesPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subject_categories';
    protected $primaryKey = 'subject_category_code';

    public $timestamps = false;
}
