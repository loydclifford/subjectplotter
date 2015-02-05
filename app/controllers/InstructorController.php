<?php

class InstructorController extends BaseController {

    public function getIndex()
    {
        // Lists
        $list = new InstructorTblist();
        $list->prepareList();

        if (Request::ajax())
        {
            return $list->toJson();
        }

        $this->data['meta']->title  = lang('instructor/texts.meta_title');
        $this->data['list']         = $list;
        $this->data['list_action']         = '#';

        return View::make('admin.instructor.index', $this->data);
    }

    public function getCreate()
    {
        // Meta Data
        $this->data['meta']->title  = lang('instructor/texts.create_meta_title');
        $this->data['page_title']   = lang('instructor/texts.create_page_title');

        // Form data
        $this->data['url']           = URL::current();
        $this->data['method']        = 'POST';
        $this->data['return_url']    = admin_url('/instructors/create');
        $this->data['success_url']   = admin_url('/instructors');

        $this->data['selected_subject_categories']   = array();

        return View::make('admin.instructor.create_edit')->with($this->data);
    }

    public function postCreate()
    {
        // Check for taxonomy slugs
        $instructor_repo = new InstructorForm(new Instructor());
        if ($has_error = $instructor_repo->validateInput())
        {
            return $has_error;
        }

        $instructor = $instructor_repo->saveInput();
        Event::fire('instructor.add', $instructor);

        return Redirect::to(Input::get('_success_url'))
            ->with(SUCCESS_MESSAGE,lang('instructor/texts.create_success'));
    }

    public function getEdit(Instructor $instructor)
    {
        $this->data['meta']->title  = lang('instructor/texts.update_meta_title');
        $this->data['page_title']   = lang('instructor/texts.update_page_title');

        $this->data['url']          = URL::current();
        $this->data['method']       = 'POST';
        $this->data['return_url']   = admin_url("/instructors/{$instructor->instructor_id}/edit");
        $this->data['success_url']  = admin_url("/instructors/{$instructor->instructor_id}/edit");

        $this->data['enable_breadcrumb']   = false;
        $this->data['instructor']         = $instructor;

        $this->data['selected_subject_categories']   = $instructor->instructorSubjectCategories->lists('subject_category_name', 'subject_category_code');

        return View::make('admin.instructor.create_edit')->with($this->data);
    }

    public function postEdit(Instructor $instructor)
    {
        // Check for taxonomy slugs
        $instructor_repo = new InstructorForm($instructor);
        if ($has_error = $instructor_repo->validateInput())
        {
            return $has_error;
        }

        $instructor = $instructor_repo->saveInput();
        Event::fire('instructor.update', $instructor);

        return Redirect::to(admin_url("instructors/{$instructor->instructor_id}/edit"))
            ->with(SUCCESS_MESSAGE,lang('instructor/texts.update_success'));
    }

    public function getDelete()
    {
        Utils::validateBulkArray('instructors_id');
        // The instructor id56665`
        $instructors_ids = Input::get('instructors_id', array());
        $instructors = Instructor::whereIn('instructor_id', $instructors_ids);
        // Delete Instructors
        Event::fire('instructor.delete', $instructors);
        $instructors->delete();

        if (Input::has('_success_url'))
        {
            return \Redirect::to(Input::get('_success_url'))
                ->with(SUCCESS_MESSAGE, lang('instructor/texts.delete_success'));
        }
        else
        {
            return Redirect::back()
                ->with(SUCCESS_MESSAGE, lang('instructor/texts.delete_success'));
        }
    }

    // Import

    public function getExport()
    {
        Utils::validateBulkArray('instructors_id');

        $array = Instructor::whereIn('id',Input::get('instructors_id'))->get()->toArray();

        // Start export if not empty
        if ( ! empty($array))
        {
            $headers = array_keys($array[0]);
            Utils::csvDownload('instructors_data_csv', $array, $headers);
        }
    }

    // Select 2 Search Instructor
    public function getSearchSelect()
    {
        if (Input::has('method') && Input::get('method') == "init-selection"){
            $instructor = Instructor::frontEndGroups()->find(Input::get('id'));

            if($instructor)
            {
                $ret['id']          = $instructor->instructor_id;
                $ret['first_name']  = $instructor->first_name;
                $ret['last_name']   = $instructor->last_name;
                $ret['email']       = $instructor->email;

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
            // If numeric, then it is id that the instructor is
            // intended to search
            $instructors = Instructor::where('id', $queue);
        }
        else
        {
            // If string, then it is a name that the instructor is
            // intended to search
            $instructors = Instructor::frontEndGroups()->where(function($query) use ($queue) {
                $query->where('first_name', 'LIKE', $queue . '%');
                $query->orWhere('last_name', 'LIKE', $queue . '%');
            });
        }

        $results = $instructors->skip($offset)
            ->take($per_page)
            ->get();

        $ret = array(
            'total' => $instructors->count()
        );

        $instructor_assoc = array();
        foreach($results as $instructor) {
            $instructor_assoc[] = array(
                'id'            => $instructor->instructor_id,
                'first_name'     => $instructor->first_name,
                'last_name'      =>$instructor->last_name,
                'email'         => $instructor->email
            );
        }

        $ret['instructors'] = $instructor_assoc;

        return Response::json($ret);
    }


}