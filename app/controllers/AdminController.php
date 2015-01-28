<?php

class AdminController extends BaseController {

    public function getIndex() {
        $this->data['meta']->title  = "Carsnow Dashboard";
        $this->data['breadcrumb']   = "admin/home";

        return View::make('admin.index',$this->data);
    }



}