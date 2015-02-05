<?php

class SubjectController extends BaseController {

    public function getIndex()
    {
        // Lists
        $list = new SubjectTblist();
        $list->prepareList();

        if (Request::ajax())
        {
            return $list->toJson();
        }

        $this->data['meta']->title  = lang('subject/texts.meta_title');
        $this->data['list']         = $list;
        $this->data['list_action']  = '#';

        return View::make('admin.subject.index', $this->data);
    }

    public function getCreate()
    {
        // Meta Data
        $this->data['meta']->title  = lang('subject/texts.create_meta_title');
        $this->data['page_title']   = lang('subject/texts.create_page_title');

        // Form data
        $this->data['url']           = URL::current();
        $this->data['method']        = 'POST';
        $this->data['return_url']    = admin_url('/subjects/create');
        $this->data['success_url']   = admin_url('/subjects');

        return View::make('admin.subject.create_edit')->with($this->data);
    }

    public function postCreate()
    {
        // Check for taxonomy slugs
        $subject_repo = new SubjectForm(new Subject());
        if ($has_error = $subject_repo->validateInput())
        {
            return $has_error;
        }

        $subject = $subject_repo->saveInput();
        Event::fire('subject.add', $subject);

        return Redirect::to(Input::get('_success_url'))
            ->with(SUCCESS_MESSAGE,lang('subject/texts.create_success'));
    }

    public function getEdit(Subject $subject)
    {
        $this->data['meta']->title  = lang('subject/texts.update_meta_title');
        $this->data['page_title']   = lang('subject/texts.update_page_title');

        $this->data['url']          = URL::current();
        $this->data['method']       = 'POST';
        $this->data['return_url']   = admin_url("/subjects/{$subject->subject_code}/edit");
        $this->data['success_url']  = admin_url("/subjects/{$subject->subject_code}/edit");

        $this->data['enable_breadcrumb']    = false;
        $this->data['subject']              = $subject;

        return View::make('admin.subject.create_edit')->with($this->data);
    }

    public function postEdit(Subject $subject)
    {
        // Check for taxonomy slugs
        $subject_repo   = new SubjectForm($subject);
        if ($has_error  = $subject_repo->validateInput())
        {
            return $has_error;
        }

        $subject = $subject_repo->saveInput();
        Event::fire('subject.update', $subject);

        return Redirect::to(admin_url("subjects/{$subject->subject_code}/edit"))
            ->with(SUCCESS_MESSAGE,lang('subject/texts.update_success'));
    }

    public function getDelete()
    {
        Utils::validateBulkArray('subject_code');
        // The subject id56665`
        $subjects_codes = Input::get('subject_code', array());
        $subjects = Subject::whereIn('subject_code', $subjects_codes);
        // Delete Subjects
        Event::fire('subject.delete', $subjects);
        $subjects->delete();

        if (Input::has('_success_url'))
        {
            return \Redirect::to(Input::get('_success_url'))
                ->with(SUCCESS_MESSAGE, lang('subject/texts.delete_success'));
        }
        else
        {
            return Redirect::back()
                ->with(SUCCESS_MESSAGE, lang('subject/texts.delete_success'));
        }
    }

    // Import

    public function getExport()
    {
        Utils::validateBulkArray('subjects_code');

        $array = Subject::whereIn('id',Input::get('subjects_id'))->get()->toArray();

        // Start export if not empty
        if ( ! empty($array))
        {
            $headers = array_keys($array[0]);
            Utils::csvDownload('subjects_data_csv', $array, $headers);
        }
    }

    // Select 2 Search Subjects
    public function getSearchSelect()
    {
        if (Input::has('method') && Input::get('method') == "init-selection"){
            $subject = Subject::frontEndGroups()->find(Input::get('id'));

            if($subject)
            {
                $ret['id']                      = $subject->subject_code;
                $ret['subject_name']            = $subject->subject_name;
                $ret['subject_category_code']   = $subject->subject_category_code;

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
            // If numeric, then it is id that the subject is
            // intended to search
            $subjects = Subject::where('id', $queue);
        }
        else
        {
            // If string, then it is a name that the subject is
            // intended to search
            $subjects = Subject::frontEndGroups()->where(function($query) use ($queue) {
                $query->where('first_name', 'LIKE', $queue . '%');
                $query->orWhere('last_name', 'LIKE', $queue . '%');
            });
        }

        $results = $subjects->skip($offset)
            ->take($per_page)
            ->get();

        $ret = array(
            'total' => $subjects->count()
        );

        $subject_assoc = array();
        foreach($results as $subject) {
            $subject_assoc[] = array(
                'id'                    => $subject->subject_code,
                'subject_name'          => $subject->subject_name,
                'subject_category_code' =>$subject->subject_category_code
            );
        }

        $ret['subjects'] = $subject_assoc;

        return Response::json($ret);
    }
}
