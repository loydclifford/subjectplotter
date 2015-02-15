<?php

class Admin_SettingController extends BaseController {

    /**
     * General
     *
     * @return \Illuminate\View\View|string
     */
    public function getIndex()
    {
        // Lists
        $this->data['meta']->title  = lang('setting/general.page_title');
        $this->data['page_title']  = lang('setting/general.page_title');
        $this->data['current_tab']  = 'general';

        return View::make('admin.setting.index', $this->data);
    }

    /**
     * General
     *
     * @return \Illuminate\View\View|string
     */
    public function getSemester()
    {
        // Lists
        $this->data['meta']->title  = lang('setting/semester.page_title');
        $this->data['page_title']  = lang('setting/semester.page_title');
        $this->data['current_tab']  = 'semester';

        return View::make('admin.setting.semester', $this->data);
    }

    public function postUpdate()
    {
        // Meta Data
        foreach (Input::get('setting', array()) as $key => $value)
        {
            Setting::addSetting($key, $value);
        }

        return Redirect::back()->with(SUCCESS_MESSAGE, 'Successfully updated settings');
    }

}