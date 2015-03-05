<?php

class Admin_DeanController extends BaseController {

    public function getIndex()
    {
        // Lists
        $list = new DeanTblist();
        $list->prepareList();

        if (Request::ajax())
        {
            return $list->toJson();
        }

        $this->data['meta']->title = lang('dean/texts.meta_title');
        $this->data['list']        = $list;
        $this->data['list_action'] = '#';

        return View::make('admin.dean.index', $this->data);
    }

    public function getCreate()
    {
        // Meta Data
        $this->data['meta']->title = lang('dean/texts.create_meta_title');
        $this->data['page_title']  = lang('dean/texts.create_page_title');

        // Form data
        $this->data['url']         = URL::current();
        $this->data['method']      = 'POST';
        $this->data['return_url']  = admin_url('/deans/create');
        $this->data['success_url'] = admin_url('/deans');

        $this->data['generated_dean_id'] = Dean::generateNewId();

        $this->data['selected_subject_categories']   = array();

        return View::make('admin.dean.create_edit')->with($this->data);
    }

    public function postCreate()
    {
        // Check for taxonomy slugs
        $dean_repo = new DeanForm(new Dean());
        if ($has_error = $dean_repo->validateInput())
        {
            return $has_error;
        }

        $dean = $dean_repo->saveInput();
        Event::fire('dean.add', $dean);

        return Redirect::to(Input::get('_success_url'))
            ->with(SUCCESS_MESSAGE,lang('dean/texts.create_success'));
    }

    public function getEdit(Dean $dean)
    {
        $this->data['meta']->title = lang('dean/texts.update_meta_title');
        $this->data['page_title']  = lang('dean/texts.update_page_title');

        $this->data['url']         = URL::current();
        $this->data['method']      = 'POST';
        $this->data['return_url']  = admin_url("/deans/{$dean->id}/edit");
        $this->data['success_url'] = admin_url("/deans/{$dean->id}/edit");

        $this->data['enable_breadcrumb'] = false;
        $this->data['dean']      = $dean;
        $this->data['dean_user'] = $dean->user;

        $this->data['selected_subject_categories'] = $dean->subjectCategory->lists('subject_category_code');

        return View::make('admin.dean.create_edit')->with($this->data);
    }

    public function postEdit(Dean $dean)
    {
        // Check for taxonomy slugs
        $dean_repo = new DeanForm($dean);
        if ($has_error = $dean_repo->validateInput())
        {
            return $has_error;
        }

        $dean = $dean_repo->saveInput();
        Event::fire('dean.update', $dean);

        return Redirect::to(admin_url("/deans/{$dean->id}/edit"))
            ->with(SUCCESS_MESSAGE,lang('dean/texts.update_success'));
    }

    public function getDelete()
    {
        Utils::validateBulkArray('deans_id');
        // The dean id56665`
        $deans_ids = Input::get('deans_id', array());

        $deans = Dean::whereIn('id', $deans_ids);
        // Delete Deans
        Event::fire('dean.delete', $deans);
        $deans->delete();

        if (Input::has('_success_url'))
        {
            return \Redirect::to(Input::get('_success_url'))
                ->with(SUCCESS_MESSAGE, lang('dean/texts.delete_success'));
        }
        else
        {
            return Redirect::back()
                ->with(SUCCESS_MESSAGE, lang('dean/texts.delete_success'));
        }
    }

    // Import
    public function getExport()
    {
        Utils::validateBulkArray('deans_id');

        $array = Dean::whereIn('id',Input::get('deans_id'))->get()->toArray();

        // Start export if not empty
        if ( ! empty($array))
        {
            $headers = array_keys($array[0]);
            Utils::csvDownload('deans_data_csv', $array, $headers);
        }
    }

    // Select 2 Search Dean
    public function getSearchSelect()
    {
        if (Input::has('method') && Input::get('method') == "init-selection"){
            $dean = Dean::frontEndGroups()->find(Input::get('id'));

            if($dean)
            {
                $ret['id']         = $dean->dean_id;
                $ret['first_name'] = $dean->first_name;
                $ret['last_name']  = $dean->last_name;
                $ret['email']      = $dean->email;

                return Response::json($ret);
            }

            return Response::json(array());
        }

        $per_page = Input::get('per_page');
        $page     = Input::get('page');
        $offset   = ($page - 1 ) * $per_page;
        $queue    = trim(Input::get('q'));

        // generate the query
        if (is_numeric($queue))
        {
            // If numeric, then it is id that the dean is
            // intended to search
            $deans = Dean::where('id', $queue);
        }
        else
        {
            // If string, then it is a name that the dean is
            // intended to search
            $deans = Dean::frontEndGroups()->where(function($query) use ($queue) {
                $query->where('first_name', 'LIKE', $queue . '%');
                $query->orWhere('last_name', 'LIKE', $queue . '%');
            });
        }

        $results = $deans->skip($offset)
            ->take($per_page)
            ->get();

        $ret = array(
            'total' => $deans->count()
        );

        $dean_assoc = array();
        foreach($results as $dean) {
            $dean_assoc[] = array(
                'id'         => $dean->dean_id,
                'first_name' => $dean->first_name,
                'last_name'  =>$dean->last_name,
                'email'      => $dean->email
            );
        }

        $ret['deans'] = $dean_assoc;

        return Response::json($ret);
    }
}
