<?php

class InstructorTblist extends BaseTblist {

    public $table = "instructors";
    public $tableId = "id";

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

        $this->columns['id'] = array(
            'label'           => 'Instructor ID',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'instructors.id',
            'thead_attr'      => ' style="width:40px" ',
        );

        $this->columns['user_id'] = array(
            'label'           => 'First Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.user_id',
            'thead_attr'      => ' style="width:120px" ',
        );

        $this->columns['user_first_name'] = array(
            'label'           => 'First Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.first_name',
            'thead_attr'      => ' style="width:120px" ',
        );

        $this->columns['user_last_name'] = array(
            'label'           => 'Last Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.last_name',
            'thead_attr'      => ' style="width:120px" ',
        );

        $this->columns['user_email'] = array(
            'label'           => 'Email',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.last_name',
            'thead_attr'      => ' style="width:120px" ',
        );

        $this->columns['user_status'] = array(
            'label'           => 'Status',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.status',
            'thead_attr'      => '',
        );

        $this->columns['user_last_login'] = array(
            'label'           => 'Last login',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.last_login',
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

    protected function colSetUserId($row)
    {
        echo Html::link(admin_url("/users/{$row->user_id}/edit"), 'User - ' . $row->user_id);
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
