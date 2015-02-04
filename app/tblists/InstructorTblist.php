<?php

class InstructorTblist extends BaseTblist {

    public $table = "instructors";
    public $tableId = "instructor_id";

    public $cbName = "instructors_id";

    function __construct()
    {
        parent::__construct();

        $this->noResults = lang('instructor/texts.no_result_found');
        // we need to create a custom method setQuery,
        $this->setQuery();

        // set table columns
        $this->setColumns();

        // Debug All Query
        // dd(DB::getQueryLog());
    }

    protected function setQuery()
    {
        // all instructors
        $this->query = Instructor::leftJoin('users', 'users.id', '=', 'instructors.user_id');

        if (Input::has('instructor_id'))
        {
            $this->query->where('instructors.id', trim(Input::get('instructor_id')));
        }

        if (Input::has('name'))
        {
            $this->query->where(function($query) {
                $query->where('users.first_name', 'LIKE', '%'.Input::get('name').'%');
                $query->where('users.last_name', 'LIKE', '%'.Input::get('name').'%');
            });
        }

        // Debug query
        $this->columnOrders = array();

        $this->columnsToSelect = array(
            'instructors.*',
            'users.first_name as users_first_name',
            'users.last_name as users_last_name',
            'users.email as users_email',
            'users.status as users_status',
            'users.last_login as users_last_login',
            'users.registration_date as users_registration_date',
        );
    }

    protected function setColumns()
    {
        $this->addCheckableColumn();

        $this->columns['instructor_id'] = array(
            'label'           => 'Instructor ID',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'instructors.id',
            'thead_attr'      => ' style="width:40px" ',
        );

        $this->columns['user_first_name'] = array(
            'label'           => 'First Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.first_name',
            'thead_attr'      => ' style="width:120px" ',
        );

        $this->columns['users_last_name'] = array(
            'label'           => 'Last Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.last_name',
            'thead_attr'      => ' style="width:120px" ',
        );

        $this->columns['users_email'] = array(
            'label'           => 'Email',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.last_name',
            'thead_attr'      => ' style="width:120px" ',
        );

        $this->columns['users_status'] = array(
            'label'           => 'Status',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.status',
            'thead_attr'      => '',
        );

        $this->columns['users_last_login'] = array(
            'label'           => 'Status',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.last_login',
            'thead_attr'      => '',
        );

        $this->columns['users_registration_date'] = array(
            'label'           => 'Status',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.registration_date',
            'thead_attr'      => '',
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
