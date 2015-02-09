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

        if (Input::has('subject_name'))
        {
            $this->query->where('subject_name','like','%'.Input::get('subject_name').'%');
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
            'label'           => 'Subject Code',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'subjects.subject_code',
            'thead_attr'      => ' style="width:30px" ',
        );

        $this->columns['subject_name'] = array(
            'label'           => 'Subject Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'subjects.subject_name',
            'thead_attr'      => ' style="width:40px" ',
        );

        $this->columns['units'] = array(
            'label'           => 'Units',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'subjects.units',
            'thead_attr'      => ' style="width:1px" ',
        );

        $this->columns['description'] = array(
            'label'           => 'Description',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'subjects.description',
            'thead_attr'      => ' style="width:80px" ',
        );

        $this->columns['prerequisite'] = array(
            'label'           => 'Prerequisites',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'subjects.prerequisite',
            'thead_attr'      => ' style="width:2px" ',
        );

        $this->columns['subject_category_code'] = array(
            'label'           => 'Subject Category Code',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'subjects.subject_category_code',
            'thead_attr'      => ' style="width:20px" ',
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
