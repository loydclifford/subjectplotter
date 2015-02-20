<?php

class GradeEntryTblist extends BaseTblist {

    public $table   = "grade-entry";
    public $tableId = "user_id";

    public $cbName  = "";

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
        // all students
        $this->query = Student::leftJoin('users', 'users.id', '=', 'students.user_id');

        if (Input::has('student_name'))
        {
            $this->query->where(function($query) {
                $query->where('users.first_name', 'LIKE', '%'.trim(Input::get('student_name')).'%');
                return $query->orWhere('users.last_name', 'LIKE', '%'.trim(Input::get('student_name')).'%');
            });
        }

        if (Input::has('user_id'))
        {
            $this->query->where('students.user_id',trim(Input::get('user_id')));
        }

        if (Input::has('course_code'))
        {
            $this->query->where('students.course_code',trim(Input::get('course_code')));
        }

        if (Input::has('course_year_code'))
        {
            $this->query->where('students.course_year_code',trim(Input::get('course_year_code')));
        }

        // Debug query
        $this->columnOrders = array();

        $this->columnsToSelect = array(
            'students.*',
            'users.id as user_id',
            'users.first_name as user_first_name',
            'users.last_name as user_last_name',
            'users.email as user_email',
            'users.status as user_status',
            'users.last_login as user_last_login',
            'users.registration_date as user_registration_date',
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
            'thead_attr'      => ' style="width:120px" ',
        );

        $this->columns['user_first_name'] = array(
            'label'           => 'First Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.first_name',
            'thead_attr'      => ' style="width:200px" ',
        );

        $this->columns['user_last_name'] = array(
            'label'           => 'Last Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.last_name',
        );

        $this->columns['course_code'] = array(
            'label'           => 'Course Code',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'students.course_code',
            'thead_attr'      => ' style="width:150px" ',
        );

        $this->columns['course_year_code'] = array(
            'label'           => 'Year Level',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'students.course_year_code',
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
