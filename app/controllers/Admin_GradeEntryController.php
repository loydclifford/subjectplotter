<?php

class Admin_GradeEntryController extends BaseController {

    public function getIndex()
    {
        // Lists
        $list = new GradeEntryTblist();
        $list->prepareList();

        if (Request::ajax())
        {
            return $list->toJson();
        }

        $this->data['meta']->title = lang('gradeentry/texts.meta_title');
        $this->data['list']        = $list;
        $this->data['list_action'] = '#';

        return View::make('admin.grade-entry.index', $this->data);
    }

    public function postCreate()
    {
        // Check for taxonomy slugs
        $grade_entry_repo = new GradeEntryForm(new GradeEntry());
        if ($has_error = $grade_entry_repo->validateInput())
        {
            return $has_error;
        }

        $grade_entry = $grade_entry_repo->saveInput();
        Event::fire('grade_entry.add', $grade_entry);

        return Redirect::to(Input::get('_success_url'))
            ->with(SUCCESS_MESSAGE, lang('grade_entry/texts.create_success'));
    }

    public function getEdit(GradeEntry $grade_entry)
    {
        $this->data['meta']->title = lang('gradeentry/texts.update_meta_title');
        $this->data['page_title']  = lang('gradeentry/texts.update_page_title');
        $this->data['url']         = URL::current();
        $this->data['method']      = 'POST';
        $this->data['return_url']  = admin_url("/grade-entry{$grade_entry->subject_name}/edit");
        $this->data['success_url'] = admin_url("/grade-entry{$grade_entry->subject_name}/edit");

        $this->data['enable_breadcrumb'] = false;
        $this->data['grade_entry']   = $grade_entry;

        return View::make('admin.grade-entry.create_edit')->with($this->data);
    }

    public function postEdit(GradeEntry $grade_entry)
    {
        // Check for taxonomy slugs
        $grade_entry_repo = new GradeEntryForm($grade_entry);
        if ($has_error = $grade_entry_repo->validateInput())
        {
            return $has_error;
        }

        $grade_entry = $grade_entry_repo->saveInput();
        Event::fire('grade-entry.update', $grade_entry);

            return Redirect::to(admin_url("subjects/categories/{$grade_entry->$subject_category_code}/edit"))
            ->with(SUCCESS_MESSAGE,lang('gradeentry/texts.update_success'));
    }

    public function getDelete()
    {
        Utils::validateBulkArray('subject_category_codes');

        // The subject
        $subject_category_codes = Input::get('subject_category_codes', array());
        $subjectcategories = GradeEntry::whereIn('subject_category_code', $subject_category_codes)->delete();

        // Delete Subjects
        Event::fire('grade_entry.delete', $subjectcategories);

        if (Input::has('_success_url'))
        {
            return Redirect::to(Input::get('_success_url'))
                ->with(SUCCESS_MESSAGE, lang('gradeentry/texts.delete_success'));
        }
        else
        {
            return Redirect::back()
                ->with(SUCCESS_MESSAGE, lang('gradeentry/texts.delete_success'));
        }
    }

    // Import
    public function getExport()
    {
        Utils::validateBulkArray('subject_category_codes');

        $array = GradeEntry::whereIn('subject_category_code', Input::get('subject_category_codes'))->get()->toArray();

        // Start export if not empty
        if ( ! empty($array))
        {
            $headers = array_keys($array[0]);
            Utils::csvDownload('subjectcategories_data_csv', $array, $headers);
        }
    }
}
