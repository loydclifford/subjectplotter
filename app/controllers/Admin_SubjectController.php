<?php

class Admin_SubjectController extends Admin_BaseController {

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
        $subject_repo  = new SubjectForm(new Subject());
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

        $this->data['enable_breadcrumb'] = false;
        $this->data['subject']           = $subject;

        return View::make('admin.subject.create_edit')->with($this->data);
    }

    public function postEdit(Subject $subject)
    {
        // Check for taxonomy slugs
        $subject_repo  = new SubjectForm($subject);
        if ($has_error = $subject_repo->validateInput())
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
        Utils::validateBulkArray('subjects_code');

        // The subject id56665`
        $subjects_codes = Input::get('subjects_code', array());
        $subjects = Subject::whereIn('subject_code', $subjects_codes)->delete();

        // Delete Subjects
         Event::fire('subject.delete', $subjects);

        if (Input::has('_success_url'))
        {
            return Redirect::to(Input::get('_success_url'))
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

        $array = Subject::whereIn('subject_code',Input::get('subjects_code'))->get()->toArray();

        // Start export if not empty
        if ( ! empty($array))
        {
            $headers = array_keys($array[0]);
            Utils::csvDownload('subjects_data_csv', $array, $headers);
        }
    }
}
