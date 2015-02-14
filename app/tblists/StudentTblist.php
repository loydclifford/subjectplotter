<?php

class StudentTblist extends BaseTblist {

    public $table   = "students";
    public $tableId = "user_id";

    public $cbName  = "user_id";

    function __construct()
    {
        parent::__construct();

        $this->noResults = lang('student/texts.no_result_found');
        // we need to create a custom method setQuery,
        $this->setQuery();

        // set table columns
        $this->setColumns();

        // Debug All Query
        // dd(DB::getQueryLog());
    }

    protected function setQuery()
    {
        // all students
        $this->query = Student::where('user_id', '<>', '0');

        if (Input::has('user_id'))
        {
            $this->query->where('students.user_id',trim(Input::get('user_id')));
        }

        if (Input::has('student_name'))
        {
            $this->query->where('students.student_name',trim(Input::get('student_name')));
        }

        if (Input::has('user_id'))
        {
            $this->query->where('students.user_id',trim(Input::get('user_id')));
        }

        // Debug query
        $this->columnOrders = array();

        $this->columnsToSelect = array(
            'students.*',
        );
    }

    protected function setColumns()
    {
        $this->addCheckableColumn();

        $this->columns['user_id'] = array(
            'label'           => 'Student ID',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'students.student_code',
            'thead_attr'      => ' style="width:100px" ',
        );

        $this->columns['first_name'] = array(
            'label'           => 'First Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'students.student_name',
            'thead_attr'      => ' style="width:200px" ',
        );

        $this->columns['last_name'] = array(
            'label'           => 'Last Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'students.units',
            'thead_attr'      => ' style="width:200px" ',
        );

        $this->columns['course_code'] = array(
            'label'           => 'Course Code',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'students.description',
            'thead_attr'      => ' style="width:200px" ',
        );

        $this->columns['course_level_code'] = array(
            'label'           => 'Course Level Code',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'students.prerequisite',
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
