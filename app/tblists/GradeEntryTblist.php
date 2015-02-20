<?php

class GradeEntryTblist extends BaseTblist {

    public $table   = "subjects";
    public $tableId = "subject_name";

    public $cbName  = "subject_name";

    function __construct()
    {
        parent::__construct();

        $this->noResults = lang('gradeentry/texts.no_result_found');

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
        $this->query = GradeEntry::where('subject_name', '<>', '0');

        if (Input::has('subject_name'))
        {
            $this->query->where('subjects.subject_name',trim(Input::get('subject_name')));
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

        $this->columns['id'] = array(
            'label'           => 'Subject',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'subjects.subject_code',
        );

        $this->columns['unit'] = array(
            'label'           => 'Units',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'subjects.subject_code',
            'thead_attr'      => ' style="width:60px" ',
        );

        $this->columns['rating'] = array(
            'label'           => 'Rating',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'subjects.subject_code',
            'thead_attr'      => ' style="width:100px" ',
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
