<?php

class Admin_SubjectCategoryController extends BaseController {

    public function getIndex()
    {
        // Lists
        $list = new SubjectCategoryTblist();
        $list->prepareList();

        if (Request::ajax())
        {
            return $list->toJson();
        }

        $this->data['meta']->title  = lang('subjectcategory/texts.meta_title');
        $this->data['list']         = $list;
        $this->data['list_action']  = '#';

        return View::make('admin.subjectcategory.index', $this->data);
    }

    public function postCreate()
    {
        // Check for taxonomy slugs
        $subjectcategory_repo  = new SubjectCategoryForm(new SubjectCategory());
        if ($has_error = $subjectcategory_repo->validateInput())
        {
            return $has_error;
        }

        $subjectcategory = $subjectcategory_repo->saveInput();
        Event::fire('subjectcategory.add', $subjectcategory);

        return Redirect::to(Input::get('_success_url'))
            ->with(SUCCESS_MESSAGE,lang('subjectcategory/texts.create_success'));
    }

    public function getEdit(SubjectCategory $subjectcategory)
    {
        $this->data['meta']->title  = lang('subjectcategory/texts.update_meta_title');
        $this->data['page_title']   = lang('subjectcategory/texts.update_page_title');
        $this->data['url']          = URL::current();
        $this->data['method']       = 'POST';
        $this->data['return_url']   = admin_url("/subjects/categories{$subjectcategory->subject_category_code}/edit");
        $this->data['success_url']  = admin_url("/subjects/categories{$subjectcategory->subject_category_code}/edit");

        $this->data['enable_breadcrumb'] = false;
        $this->data['subjectcategory']   = $subjectcategory;

        return View::make('admin.subjectcategory.create_edit')->with($this->data);
    }

    public function postEdit(SubjectCategory $subjectcategory)
    {
        // Check for taxonomy slugs
        $subjectcategory_repo  = new SubjectCategoryForm($subjectcategory);
        if ($has_error = $subjectcategory_repo->validateInput())
        {
            return $has_error;
        }

        $subjectcategory = $subjectcategory_repo->saveInput();
        Event::fire('subjectcategory.update', $subjectcategory);

            return Redirect::to(admin_url("subjects/categories/{$subjectcategory->$subject_category_codes}/edit"))
            ->with(SUCCESS_MESSAGE,lang('subjects/categories/texts.update_success'));
    }

    public function getDelete()
    {
        Utils::validateBulkArray('subject_category_codes');

        // The subject id56665`
        $subject_category_codes = Input::get('subject_category_codes', array());
        $subjectcategories = SubjectCategory::whereIn('subject_category_code', $subject_category_codes)->delete();

        // Delete Subjects
        Event::fire('subjectcategory.delete', $subjectcategories);

        if (Input::has('_success_url'))
        {
            return Redirect::to(Input::get('_success_url'))
                ->with(SUCCESS_MESSAGE, lang('subjectcategory/texts.delete_success'));
        }
        else
        {
            return Redirect::back()
                ->with(SUCCESS_MESSAGE, lang('subjectcategory/texts.delete_success'));
        }
    }

    // Import
    public function getExport()
    {
        Utils::validateBulkArray('subject_category_code');

        $array = SubjectCategory::whereIn('subject_category_code',Input::get('subject_category_codes'))->get()->toArray();

        // Start export if not empty
        if ( ! empty($array))
        {
            $headers = array_keys($array[0]);
            Utils::csvDownload('subjectcategories_data_csv', $array, $headers);
        }
    }
}
