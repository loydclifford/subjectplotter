<?php

class CourseController extends BaseController {

    protected $langPrefix = 'course/';

    public function lang($langLine)
    {
        return lang($this->langPrefix.$langLine);
    }

    public function getIndex()
    {
        // Lists
        $list = new CourseTblist();
        $list->prepareList();

        if (Request::ajax())
        {
            return $list->toJson();
        }

        $this->data['meta']->title  = $this->lang('texts.page_title');
        $this->data['list']         = $list;
        $this->data['list_action']         = '#';

        return View::make('admin.course.index', $this->data);
    }   

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
        $course_repo = new CourseForm(new Course());
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

        $this->data['enable_breadcrumb'] = false;
        $this->data['course']            = $course;

        return View::make('admin.course.create_edit')->with($this->data);
    }

    public function postEdit(Course $course)
    {
        // Check for taxonomy slugs
        $course_repo = new CourseForm($course);
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
        $base_course_year_uri = "/courses/{$course->course_code}/view";

        $this->data['meta']->title  = lang('course/texts.view_meta_title');

        $this->data['enable_breadcrumb']    = false;
        $this->data['course']               = $course;
        $this->data['base_items_uris']      = admin_url("/course/{$course->course_code}/view");

        $this->data['base_course_year_uri'] = $base_course_year_uri;

        // Form Create URL
        $this->data['form_url']  = admin_url('/course-years/create');

        // Set flag as not an update
        $this->data['is_update'] = FALSE;

        // Identify if has selected course year
        if (Input::has('course_year_code'))
        {
            $course_year = CourseYear::where('course_year_code', Input::get('course_year_code'))
                                    ->where('course_code', $course->course_code)->first();
            if ($course_year)
            {
                $this->data['is_update']   = TRUE;
                $this->data['course_year'] = $course_year;
                $this->data['form_url']    = admin_url('/course-years/update');
            }
            else
            {
                $redirect_to = admin_url($base_course_year_uri.'?'.http_build_query(Request::except('course_year_code')));
                return Redirect::to($redirect_to);
            }
        }

        return View::make('admin.course.view')->with($this->data);
    }

    public function getDelete()
    {
        Utils::validateBulkArray('course_code');

        // The course id56665`
        $course_codes = Input::get('course_code', array());
        $courses = Course::whereIn('id', $course_codes)->delete();

        // Delete Courses
        Event::fire('course.delete', $courses);

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