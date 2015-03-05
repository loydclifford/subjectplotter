<?php

class Admin_AdminController extends BaseController {

    public function getIndex() {
        $this->data['meta']->title  = "Subject Plotter";
        $this->data['breadcrumb']   = "admin/home";

        return View::make('admin.index',$this->data);
    }

    public function getLogout()
    {
        Auth::logout();

        return Redirect::to(admin_url('/'));
    }

}
