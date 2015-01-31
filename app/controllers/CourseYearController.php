<?php

class CourseYearController extends BaseController {

    public function getCreate()
    {
        // Meta Data
        $this->data['meta']->title  = lang('course/texts.create_meta_title');
        $this->data['page_title']   = lang('course/texts.create_page_title');

        // Form data
        $this->data['url']           = URL::current();
        $this->data['method']        = 'POST';
        $this->data['return_url']    = admin_url('/courses/create');
        $this->data['success_url']   = admin_url('/courses');

        return View::make('admin.course.create_edit')->with($this->data);
    }

    public function postCreate()
    {
        // Check for taxonomy slugs
        $course_repo = new CourseYearForm(new Course());
        if ($has_error = $course_repo->validateInput())
        {
            return $has_error;
        }

        $course = $course_repo->saveInput();
        Event::fire('course.add', $course);

        return Redirect::to(Input::get('_success_url'))
            ->with(SUCCESS_MESSAGE,lang('course/texts.create_success'));
    }

    public function getEdit(Course $course)
    {
        $this->data['meta']->title  = lang('course/texts.update_meta_title');
        $this->data['page_title']   = lang('course/texts.update_page_title');

        $this->data['url']          = URL::current();
        $this->data['method']       = 'POST';
        $this->data['return_url']   = admin_url("/courses/{$course->course_code}/edit");
        $this->data['success_url']  = admin_url("/courses/{$course->course_code}/edit");

        $this->data['enable_breadcrumb']   = false;
        $this->data['course']         = $course;

        return View::make('admin.course.create_edit')->with($this->data);
    }

    public function postEdit(Course $course)
    {
        // Check for taxonomy slugs
        $course_repo = new CourseYearForm($course);
        if ($has_error = $course_repo->validateInput())
        {
            return $has_error;
        }

        $course = $course_repo->saveInput();
        Event::fire('course.update', $course);

        return Redirect::to(admin_url("/courses/{$course->course_code}/edit"))
            ->with(SUCCESS_MESSAGE,lang('course/texts.update_success'));
    }

    public function getView(Course $course)
    {
        $this->data['meta']->title  = lang('course/texts.view_meta_title');

        $this->data['enable_breadcrumb']    = false;
        $this->data['course']               = $course;
        $this->data['base_items_uris']      = admin_url("/course/{$course->course_code}/view");



        return View::make('admin.course.view')->with($this->data);
    }

    public function getDelete()
    {
        Utils::validateBulkArray('courses_id');
        // The course id56665`
        $courses_ids = Input::get('courses_id', array());
        $courses = Course::whereIn('course_code', $courses_ids);
        // Delete Courses
        Event::fire('course.delete', $courses);
        $courses->delete();

        if (Input::has('_success_url'))
        {
            return \Redirect::to(Input::get('_success_url'))
                ->with(SUCCESS_MESSAGE, lang('course/texts.delete_success'));
        }
        else
        {
            return Redirect::back()
                ->with(SUCCESS_MESSAGE, lang('course/texts.delete_success'));
        }
    }

    // Import

    public function getExport()
    {
        Utils::validateBulkArray('courses_id');

        $array = Course::whereIn('id',Input::get('courses_id'))->get()->toArray();

        // Start export if not empty
        if ( ! empty($array))
        {
            $headers = array_keys($array[0]);
            Utils::csvDownload('courses_data_csv', $array, $headers);
        }
    }

    // Select 2 Search Course
    public function getSearchSelect()
    {
        if (Input::has('method') && Input::get('method') == "init-selection"){
            $course = Course::frontEndGroups()->find(Input::get('id'));

            if($course)
            {
                $ret['id']          = $course->course_code;
                $ret['first_name']  = $course->first_name;
                $ret['last_name']   = $course->last_name;
                $ret['email']       = $course->email;

                return Response::json($ret);
            }

            return Response::json(array());
        }

        $per_page   = Input::get('per_page');
        $page       = Input::get('page');
        $offset     = ($page - 1 ) * $per_page;
        $queue      = trim(Input::get('q'));

        // generate the query
        if (is_numeric($queue))
        {
            // If numeric, then it is id that the course is
            // intended to search
            $courses = Course::where('id', $queue);
        }
        else
        {
            // If string, then it is a name that the course is
            // intended to search
            $courses = Course::frontEndGroups()->where(function($query) use ($queue) {
                $query->where('first_name', 'LIKE', $queue . '%');
                $query->orWhere('last_name', 'LIKE', $queue . '%');
            });
        }

        $results = $courses->skip($offset)
            ->take($per_page)
            ->get();

        $ret = array(
            'total' => $courses->count()
        );

        $course_assoc = array();
        foreach($results as $course) {
            $course_assoc[] = array(
                'id'            => $course->course_code,
                'first_name'     => $course->first_name,
                'last_name'      =>$course->last_name,
                'email'         => $course->email
            );
        }

        $ret['courses'] = $course_assoc;

        return Response::json($ret);
    }


}