<?php

class RoomTblist extends BaseTblist {

    public $table = "rooms";
    public $tableId = "room_id";

    public $cbName = "rooms_id";

    function __construct()
    {
        parent::__construct();

        $this->noResults = lang('room/texts.no_result_found');
        // we need to create a custom method setQuery,
        $this->setQuery();

        // set table columns
        $this->setColumns();

        // Debug All Query
        // dd(DB::getQueryLog());
    }

    protected function setQuery()
    {
        // all rooms
        $this->query = Room::where('room_id', '<>', '0');

        if (Input::has('room_id'))
        {
            $this->query->where('rooms.room_id',trim(Input::get('room_id')));
        }

        if (Input::has('description'))
        {
            $this->query->where('description','like','%'.Input::get('description').'%');
        }

        // Debug query
        $this->columnOrders = array();

        $this->columnsToSelect = array(
            'rooms.*',
        );
    }

    protected function setColumns()
    {
        $this->addCheckableColumn();

        $this->columns['room_id'] = array(
            'label'           => 'Room ID',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'rooms.room_id',
            'thead_attr'      => ' style="width:40px" ',
        );

        $this->columns['description'] = array(
            'label'           => 'Description',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'rooms.description',
            'thead_attr'      => ' style="width:120px" ',
        );

        $this->columns['room_capacity'] = array(
            'label'           => 'Room Capacity',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'rooms.description',
            'thead_attr'      => ' style="width:120px" ',
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
