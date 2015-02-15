<?php

class Admin_AdminController extends Admin_BaseController {

    public function getIndex() {
        $this->data['meta']->title  = "Subject Plotter";
        $this->data['breadcrumb']   = "admin/home";

        return View::make('admin.index',$this->data);
    }

}
