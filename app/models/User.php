<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface{

    /**
     * The User Root ID
     *
     * @var integer
     */
    const USER_ROOT = 1;

	use UserTrait;

    const STATUS_ACTIVE                 = 'Active';
    const STATUS_INACTIVE               = 'Inactive';

    public static $statuses = array(
        self::STATUS_ACTIVE                 => self::STATUS_ACTIVE,
        self::STATUS_INACTIVE               => self::STATUS_INACTIVE
    );

    const USER_TYPE_ADMIN = 1;
    const USER_TYPE_INSTRUCTOR = 2;
    const USER_TYPE_STUDENT = 3;

    public static $userTypes = array(
        self::USER_TYPE_ADMIN   => 'admin',
        self::STATUS_INACTIVE   => 'Instructor',
        self::USER_TYPE_STUDENT => 'Student'
    );

    // Presenter
    use PresentableTrait;
    protected $presenter = 'UserPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public function timezone()
    {
        return $this->belongsTo('Timezone');
    }

    public function customerDetail()
    {
        return $this->hasOne('UserAccount');
    }

    public function tax_rates()
    {
        return $this->hasMany('TaxRate');
    }

    public function socialProfiles() {
        return $this->hasMany('SocialProfile');
    }

    // Localization Configuration

    public function country()
    {
        return $this->belongsTo('Country');
    }

    public function date_format()
    {
        return $this->belongsTo('DateFormat');
    }

    // SCOPES

    public function scopeEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeConfirmationCode($query, $confirmation_code)
    {
        return $query->where('confirmation_code', $confirmation_code);
    }

    public function scopeRegistrationDateYearMonthDay($query, $year, $month, $day)
    {
        // @todo only frontend user in here
        return $query->where(function($query) use ($year, $month, $day) {
               $query->where(DB::raw('YEAR(registration_date)'), $year);
               $query->where(DB::raw('MONTH(registration_date)'), $month);
               $query->where(DB::raw('DAY(registration_date)'), $day);
        });
    }

    public function scopeRegistrationDateYearMonth($query, $year, $month)
    {
        // @todo only frontend user in here
        return $query->where(function($query) use ($year, $month) {
               $query->where(DB::raw('YEAR(registration_date)'), $year);
               $query->where(DB::raw('MONTH(registration_date)'), $month);
        });
    }

    public function scopeRegistrationDateYear($query, $year)
    {
        // @todo only frontend user in here
        return $query->where(function($query) use ($year) {
               $query->where(DB::raw('YEAR(registration_date)'), $year);
        });
    }


    // PRESENTER

    public function getTimezone()
    {
        if ($this->timezone)
        {
            return $this->timezone->name;
        }
        else
        {
            return 'US/Eastern';
        }
    }

    public function loadLocalizationSettings()
    {
        // @todo: identify what is the default timezone and how to set default
        $this->load('timezone', 'date_format');

        // use only default timezone
        Session::put(SESSION_TIMEZONE, conf('user::default_timezone'));
        Session::put(SESSION_DATE_FORMAT, conf('user::default_date_format'));
        Session::put(SESSION_TIME_FORMAT,  conf('user::default_time_format'));
        Session::put(SESSION_DATE_PICKER_FORMAT, conf('user::default_date_picker_format'));
        Session::put(SESSION_CURRENCY, conf('user::default_currency'));
        Session::put(SESSION_LOCALE, conf('user::default_locale'));
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }


    // Add, Save, Update Delete for user

    function deleteData() {
        return $this->delete();
    }

    // Former Array Helper


    /**
     * Generate Unique Token, and ensure that it is unique by looping
     *
     * @param string $type
     * @return null|string
     * @author Rex Taylor
     */
    public static function generateToken()
    {
        while(empty($token))
        {
            $token = Str::random(40);
            $token_found = self::confirmationCode($token)->first();

            if ($token_found) $token = null;
        }

        return $token;
    }
}
