<?php

/**
 * A simple authentication system build for laravel
 *
 * Class SimpleAuth
 * @author: Rex Taylor
 * @version: 2.1
 * @change-logs:
 *      0.1 - initial release - laravel version 4.* and up
 *      2.1 - Laravel Multi-Auth Support - laravel version 4.* and up
 *
 */
class SimpleAuth {

    CONST CACHED_PREFIX_KEY = "SIMPLE_AUTH_V__";

    /**
     * Credentials passed to constructor
     *
     * @var array
     */
    protected $credentials = array(
        'email'                     => FALSE,
        'username'                  => FALSE,
        'password'                  => "",
        'remember'                  => FALSE,
        'confirmed_only'            => TRUE,
        'throttle_limit'            => 21,
        'throttle_time_period'      => 30,
        'signup_cache'              => 20
    );

    /**
     * Which model to use
     * Must extend the base user
     *
     * @var Eloquent
     */
    protected $user;

    /**
     * Which model to use
     * Must extend the base user
     *
     * @var Eloquent
     */
    protected $auth;

    /**
     * Error string
     *
     * @var
     */
    protected $error;

    /**
     * Create new instance of SimpleAuth
     *
     * @param array     $credentials    - Merge on credentials property
     * @param Eloquent  $user           - The Model to use
     */
    function __construct($credentials, Eloquent $user)
    {
        $this->credentials = array_merge($this->credentials,$credentials);

        // Set user object
        $this->user = $user;
        $this->auth = Auth::user();

        $this->attempt();
    }

    /**
     * If instantiated, check if passed credentials has matched the
     * database data for the given username or email and password
     *
     * @return void
     */
    public function attempt()
    {
        // if reached login attempt then set error
        // and stop attempt
        if ($this->hasReachedThrottle())
        {
            $this->setError(lang('simpleauth.reached_Throttle'));
            return ;
        }

        // Find the user
        $found_user = $this->getUser();

        // If user does not found
        // then increase the attempt of login
        if ( ! $found_user)
        {
            $this->setError(lang('simpleauth.user_does_not_exists'));
            $this->increaseAttempt();
            return ;
        }


        // Check the given password and found user password is matched
        if (Hash::check($this->getCredential('password'), $found_user->password))
        {
            // Check if confirmed only
            if ($this->getCredential('confirmed_only', false))
            {
                if ($found_user->confirmed != 1)
                {
                    $this->setError(lang('simpleauth.not_confirmed'));
                    return ;
                }
            }

            Auth::login($found_user, $this->getCredential('remember'));
        }
        else
        {
            $this->setError(lang('simpleauth.password_incorrect'));

            $this->increaseAttempt();
        }
    }

    /**
     * Get user from email or username or email and username
     *
     * @return mixed
     */
    public function getUser()
    {
        // Check what type of credentials has passed
        // Simple credentials assume that email or username are
        // unique (which will always be)
        if ($this->hasCredential('email') && $this->hasCredential('username'))
        {
            $user = $this->user->where('email', $this->getCredential('email'))
                ->where('username', $this->getCredential('username'));
        }
        else if ($this->hasCredential('email'))
        {
            $user = $this->user->where('email', $this->getCredential('email'));
        }
        else if ($this->hasCredential('username'))
        {
            $user = $this->user->where('username', $this->getCredential('username'));
        }

        // Get the first found user
        return $user->first();
    }

    /**
     * Check if key is exists in credentials property
     *
     * @param $key_name
     * @return bool
     */
    public function hasCredential($key_name)
    {
        return isset($this->credentials[$key_name]) && $this->credentials[$key_name] !== FALSE;
    }

    /**
     * Get the value from key in credentials property
     *
     * @param $key_name
     * @param null $default
     * @return null
     */
    public function getCredential($key_name,$default = NULL)
    {
        return $this->hasCredential($key_name) ? $this->credentials[$key_name] : $default;
    }

    /**
     * General cached name
     *
     * @return string
     */
    protected function getCacheName()
    {
        return self::CACHED_PREFIX_KEY . '_' . client_ip();
    }

    // Throttle

    /**
     * Attempt cached name
     *
     * @return string
     */
    protected function getAttemptCacheName()
    {
        return $this->getCacheName() . "_attempt";
    }

    /**
     * If reached the limit
     *
     * @return bool
     */
    public function hasReachedThrottle()
    {
        $attempt_key = $this->getAttemptCacheName();
        $attempts = Cache::get($attempt_key, 0);

        return $attempts > $this->getCredential('throttle_limit', 15);
    }

    /**
     * Increase the attempt of login
     *
     */
    public function increaseAttempt()
    {
        $attempt_key = $this->getAttemptCacheName();
        $attempts = Cache::get($attempt_key, 0);

        $throttle_time_period = $this->getCredential('throttle_time_period', 10);

        // used throttling login attempts
        Cache::put($attempt_key, $attempts + 1, $throttle_time_period);
    }


    // Sign UP Cache
    /**
     * get signup cache name
     *
     * @return string
     */
    protected function getSignupCacheName()
    {
        return $this->getCacheName() . "_signup_cached";
    }

    /**
     * Set the allowed signup for the same ip
     * if already been signup, then user should wait after he can
     * signup again.
     *
     * @return void
     */
    public function setSignupCache()
    {
        $signup_key = $this->getSignupCacheName();

        Cache::put($signup_key, true, $this->getCredential('signup_cache',20));
    }

    /**
     * if user can signup see 'setSignupCache'
     *
     * @return mixed
     */
    public function canSignup()
    {
        $attempt_key = $this->getSignupCacheName();

        return Cache::get($attempt_key, false);
    }


    private function setError($error_string)
    {
        $this->error = $error_string;
    }

    /**
     * Get the error string
     *
     * @return string
     */
    public function getError()
    {
        if ($this->hasError())
        {
            return $this->error;
        }
        else
        {
            return NULL;
        }
    }

    /**
     * if attempt has error
     *
     * @return bool
     */
    private function hasError()
    {
        return (! empty($this->error));
    }

    /**
     * if attempt is faield
     *
     * @return bool
     */
    public function failed()
    {
        return $this->hasError();
    }

    /**
     * If attempt is success
     *
     * @return bool
     */
    public function success()
    {
        return ! $this->failed();
    }
}