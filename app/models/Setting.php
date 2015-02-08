<?php

class Setting extends Eloquent {

    // Presenter
    use PresentableTrait;
    protected $presenter = 'SettingPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';
    protected $primaryKey = 'id';

    public $timestamps = false;

    public static function addSetting($key, $value = NULL)
    {
        $setting = Setting::where('setting_key', $key)->first();
        if ( ! $setting)
        {
            $setting = new Setting();
        }

        $setting->setting_key = $key;
        $setting->setting_value = array2db_value($value);
        $setting->save();

        return $setting;
    }

    public static function getSetting($key, $default = NULL)
    {
        $setting = Setting::where('setting_key', $key)->first();

        return $setting ? $setting->present()->getSettingValue() : $default;
    }

    public static function hasSetting($key)
    {
        return Setting::where('setting_key', $key)->count();
    }


}
