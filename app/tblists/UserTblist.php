<?php

class UserTblist extends BaseTblist {

    public $table = "users";
    public $tableId = "id";

    public $cbName = "users_id";

    function __construct()
    {
        parent::__construct();

        $this->noResults = lang('user/texts.no_result_found');
        // we need to create a custom method setQuery,
        $this->setQuery();

        // set table columns
        $this->setColumns();

        // Debug All Query
        // dd(DB::getQueryLog());
    }

    protected function setQuery()
    {
        // all users
        $this->query = User::where('id', '<>', 0);

        if (Input::has('user_id'))
        {
            $this->query->where('users.id',trim(Input::get('user_id')));
        }

        // We can use a filter by using eloquent where.
        // check if email url param is set
        if (Input::has('email'))
        {
            $this->query->where('users.email','like','%'.Input::get('email').'%');
        }

        if (Input::has('name'))
        {
            $this->query->where(\DB::raw('concat(users.first_name," ",users.last_name)'),'like','%'.Input::get('name').'%');
        }

        if (Input::has('status'))
        {
            $this->query->where('users.status',Input::get('status'));
        }

        // Debug query
        // $this->query->toSql();
        $this->columnOrders = array();

        $this->columnsToSelect = array(
            'users.*',
        );
    }

    protected function setColumns()
    {
        $this->addCheckableColumn();

        $this->columns['id'] = array(
            'label'           => 'Last Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.id',
            'thead_attr'      => ' style="width:40px" ',
        );

        $this->columns['first_name'] = array(
            'label'           => 'First Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.first_name',
            'thead_attr'      => ' style="width:120px" ',
        );

        $this->columns['last_name'] = array(
            'label'           => 'Last Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.last_name',
            'thead_attr'      => ' style="width:120px" ',
        );

        $this->columns['email'] = array(
            'label'           => 'Email',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.email'
        );

        $this->columns['user_type'] = array(
            'label'           => 'User Type',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'groups.display_name',
            'thead_attr'      => ' style="width:70px" ',
        );

        $this->columns['status'] = array(
            'label'           => 'Status',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.status',
            'thead_attr'      => ' style="width:80px" ',
        );

        $this->columns['last_login'] = array(
            'label'           => 'Last Login',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.last_login',
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
