<?php

/**
 * We don't used admin reminder because of MULTI AUTH Supprot
 * For this version of laravel 4.2, multi auth is not supported
 * in laravel core, so we need to use the extension called MULTI-AUTH
 *
 * MULTI-AUTH does not support the default PasswordReminder so we
 * need to write our own here from scratch.
 *
 * Class RemindersController
 * @package App\CMS\Modules\Admin\Controller
 * @author: Rex Taylor <rex@lightmedia.com.au>
 */
class PasswordReminder extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'password_reminders';
    public $timestamps = false;
    protected $softDelete = false;

    // Scopes
    /**
     * Find row by token
     *
     * @param $token
     * @return mixed
     */
    public static function scopeToken($query, $token)
    {
        return $query->where('token',$token);
    }

    /**
     * Generate Unique Token, and ensure that it is unique by looping
     *
     * @param string $type
     * @return null|string
     * @author Rex Taylor
     */
    public static function generateToken($type = "user")
    {
        while(empty($token))
        {
            $token = Str::random(40);
            $token_found = self::findByToken($token);

            if ($token_found) $token = null;
        }

        return $token;
    }

    /**
     * Save new password forgot request to database
     *
     * @param Eloquent $user - Model that extend BaseUser Model
     * @param $token - generated token
     * @return mixed - Model $user Object
     */
    public static function addReminder(Eloquent $user, $token)
    {
        $self = new self;
        $self->email = $user->email;
        $self->token = $token;
        $self->created_at = Carbon::now()->toDateTimeString();

        return $self->save();
    }

    /**
     * We need to validate the token saved from the database.
     *
     * @param String $token - token
     * @param Integer $max_hour - max hour it is valid
     * @return Bool
     */
    public static function isValidToken($token, $max_hour)
    {
        // Validate if token exists
        $is_found = self::findByToken($token);

        if ( ! $is_found)
        {
            return FALSE;
        }

        // Validate if token exists in the model
        if ( ! self::where('email',$is_found->email)->first())
        {
            return FALSE;
        }

        // Is Token Request Available
        $time_ago = \Carbon\Carbon::createFromTimeStamp(strtotime($is_found->created_at));
        $time_now = \Carbon\Carbon::now();
        $time_lapsed = $time_now->diffInHours($time_ago);

        if ($time_lapsed > $max_hour)
        {
            return FALSE;
        }

        // if all required validation has passed
        // then return success
        return TRUE;
    }

}

