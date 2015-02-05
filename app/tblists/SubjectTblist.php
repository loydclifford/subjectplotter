<?php

class SubjectTblist extends BaseTblist {

    public $table = "subjects";
    public $tableId = "subject_code";

    public $cbName = "subjects_id";

    function __construct()
    {
        parent::__construct();

        $this->noResults = lang('subject/texts.no_result_found');
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
        $this->query = Subject::where('subject_code', '<>', '0');

        if (Input::has('subject_code'))
        {
            $this->query->where('subjects.subject_code',trim(Input::get('subject_code')));
        }

        if (Input::has('description'))
        {
            $this->query->where('description','like','%'.Input::get('description').'%');
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

        $this->columns['subject_code'] = array(
            'label'           => 'Subject ID',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'subjects.subject_code',
            'thead_attr'      => ' style="width:40px" ',
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
