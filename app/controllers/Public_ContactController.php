<?php

class Public_ContactController extends BaseController {

    public function getIndex()
    {
        $this->data['meta']->title = 'Contact Admin';
        $this->data['active_menu'] = 'contact';

        return View::make('public.contact')->with($this->data);
    }

    public function postIndex()
    {

    }

}