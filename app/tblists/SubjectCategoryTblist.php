<?php

class SubjectCategoryTblist extends BaseTblist {

    public $table = "subject_categories";
    public $tableId = "subject_category_code";

    public $cbName = "subject_category_code";

    function __construct()
    {
        parent::__construct();

        $this->noResults = lang('subjectcategory/texts.no_result_found');
        // we need to create a custom method setQuery,
        $this->setQuery();

        // set table columns
        $this->setColumns();

        // Debug All Query
        // dd(DB::getQueryLog());
    }

    protected function setQuery()
    {
        // all subjects
        $this->query = Subject::where('subject_category_code', '<>', '0');

        if (Input::has('subject_category_code'))
        {
            $this->query->where('subject_categories.subject_category_code',trim(Input::get('subject_category_code')));
        }

        if (Input::has('subject_category_name'))
        {
            $this->query->where('subject_category_name','like','%'.Input::get('subject_category_name').'%');
        }

        // Debug query
        $this->columnOrders = array();

        $this->columnsToSelect = array(
            'subjects.*',
        );
    }

    protected function setColumns()
    {
        $this->addCheckableColumn();

        $this->columns['subject_category_code'] = array(
            'label'           => 'Subject Category Code',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'subjects.subject_code',
            'thead_attr'      => ' style="width:300px" ',
        );

        $this->columns['subject_category_name'] = array(
            'label'           => 'Subject Category Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'subjects.subject_code',
        );


        $this->addActionColumn();
    }


    protected function colSetAction($row)
    {
        echo $row->present()->actionButtons();
    }

    protected function colSetId($row)
    {
        echo $row->present()->idLink();
    }

    protected function colSetGroupDisplayName($row)
    {
        echo $row->group_display_name;
    }

    protected function colSetLastLogin($row)
    {
        echo Utils::formatDateTime(strtotime($row->last_login));
    }

    protected function colSetRegistrationDate($row)
    {
        echo Utils::timestampToDateString(strtotime($row->registration_date));
    }

    protected function colSetOrganizationName($row)
    {
        $row->present()->getOrganizationName();
    }

}
