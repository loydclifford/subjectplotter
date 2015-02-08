<?php

class SettingPresenter extends Presenter{


    // Actions Buttons and URLS Presenters
    public function getSettingValue()
    {
        return db2array_value($this->setting_value);
    }


}