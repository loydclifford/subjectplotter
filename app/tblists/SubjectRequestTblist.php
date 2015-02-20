<?php

class SubjectRequestTblist extends BaseTblist {

    public $table   = "student_plotting";
    public $tableId = "id";

    public $cbName  = "student_plotting_id";

    function __construct()
    {
        parent::__construct();

        $this->noResults = 'No plotting found.';

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
        $this->query = StudentPlotting::leftJoin('students', 'students.student_no', '=', 'student_plotting.student_no')
                    ->leftJoin('users', 'users.id', '=', 'students.user_id');

        if (Input::has('course_code'))
        {
            $this->query->where('student_plotting.course_code', trim(Input::get('course_code')));
        }

        if (Input::has('course_year_code'))
        {
            $this->query->where('student_plotting.course_year_code', trim(Input::get('course_year_code')));
        }

        if (Input::has('semester'))
        {
            $this->query->where('student_plotting.semester', trim(Input::get('semester')));
        }

        if (Input::has('status'))
        {
            $this->query->where('student_plotting.status', trim(Input::get('status')));
        }

        // Debug query
        $this->columnOrders = array();

        $this->columnsToSelect = array(
            'student_plotting.*',
            'students.student_no as student_no',
            'users.first_name as first_name',
            'users.last_name as last_name',
        );
    }

    protected function setColumns()
    {
        $this->addCheckableColumn();

        $this->columns['student_no'] = array(
            'label'           => 'Student No.',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'students.student_no',
        );

        $this->columns['first_name'] = array(
            'label'           => 'First Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.first_name',
        );

        $this->columns['last_name'] = array(
            'label'           => 'Last Name',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'users.last_name',
        );

        $this->columns['course_code'] = array(
            'label'           => 'Course Code',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'student_plotting.course_code',
        );

        $this->columns['course_year_code'] = array(
            'label'           => 'Course Year Code',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'student_plotting.course_year_code',
        );

        $this->columns['semester'] = array(
            'label'           => 'Semester',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'student_plotting.semester',
        );

        $this->columns['status'] = array(
            'label'           => 'Status',
            'sortable'        => true,
            'classes'         => 'hidden-xs hidden-sm',
            'table_column'    => 'student_plotting.status',
        );

        $this->addActionColumn();
    }


    protected function colSetAction($row)
    {
        ?>
        <div class="btn-group" id="">
            <a href="<?php echo admin_url("/schedule-requests/{$row->id}/view") ?>" class="btn btn-primary">View</a>
            <button data-toggle="dropdown" type="button" class="btn btn-info dropdown-toggle">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right text-left">
                <li>
                    <a class="confirm_action" data-message="Are you sure you want to approve this plotting?" href="<?php echo admin_url("/schedule-requests/{$row->id}/approved") ?>">
                        Approve Plotting
                    </a>
                    <a class="confirm_action" data-message="Are you sure you want to deny plotting?" href="<?php echo admin_url("/schedule-requests/{$row->id}/deny") ?>">
                        Deny
                    </a>
                </li>
            </ul>
        </div>
        <?php
    }

    protected function colSetId($row)
    {
        return HTML::link(admin_url("/users/{$this->id}/edit"), $this->id);
    }

    protected function colSetSemester($row)
    {
        echo $row->semester == 'first_semester' ? 'First Semester' : 'Second Semester';
    }
}
