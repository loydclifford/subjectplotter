<?php

class CourseTblist extends BaseTblist {

    public $table = "courses";
    public $tableId = "course_code";

    public $cbName = "courses_id";

    function __construct()
    {
        parent::__construct();

        $this->noResults = lang('course/texts.no_result_found');
        // we need to create a custom method setQuery,
        $this->setQuery();

        // set table columns
        $this->setColumns();

        // Debug All Query
        // dd(DB::getQueryLog());
    }

    protected function setQuery()
    {
        // all courses
        $this->query = Course::where('course_code', '<>', '0');

        if (Input::has('course_code'))
        {
            $this->query->where('courses.course_code',trim(Input::get('course_code')));
        }

        if (Input::has('description'))
        {
            $this->query->where('description','like','%'.Input::get('description').'%');
        }

        // Debug query
        $this->columnOrders = array();

        $this->columnsToSelect = array(
            'courses.*',
        );
    }

    protected function setColumns()
    {
        $this->addCheckableColumn();

        $this->columns['course_code'] = array(
            'label'           => 'Course ID',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'courses.course_code',
            'thead_attr'      => ' style="width:40px" ',
        );

        $this->columns['description'] = array(
            'label'           => 'Description',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'courses.description',
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
