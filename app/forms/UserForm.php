<?php

class UserForm {

    /**
     * User class instance
     *
     * @var User
     */
    protected $user;

    /**
     * Create instance of UserRepo
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Validate Submitted form
     *
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function validateInput($input = null)
    {
        // do validation
        $input = ! empty($input) ? $input : Input::all();
        $return_url = array_get($input, '_return_url');

        // Default rules
        $rules = array(
            'first_name'                => 'required',
            'last_name'                 => 'required',
            'password'			        => 'password|required',
            'password_confirmation' 	=> 'same:password|required',
            'email'                     => 'required|email|unique:users,email',
            'user_type'                  => 'required',
        );

        // If Edit
        if ( ! empty($this->user->id) && $this->user->id > 0)
        {
            // We don't want to
            if ($this->user->email == array_get($input, 'email'))
            {
                unset($rules['email']);
            }

            // Check if password is set, then set new password
            if (Input::has('password') && trim(array_get($input, 'password')) != "")
            {
                $rules['password'] = 'password';
                $rules['password_confirmation'] = 'same:password|required';
            }
            else
            {
                unset($rules['password']);
                unset($rules['password_confirmation']);
            }
        }

        $validator = Validator::make($input,$rules);

        if($validator->fails())
        {
            return Redirect::to($return_url)
                ->withErrors($validator)
                ->withInput()
                ->with(ERROR_MESSAGE,"Please correct the error below.");
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Assume that validate method is already called.
     * Save submitted form
     *
     * @return
     */
    public function saveInput($input = null)
    {
        $input = ! empty($input) ? $input : Input::all();

        // Do a security check  // Do save
        $this->user->first_name = array_get($input, 'first_name');
        $this->user->last_name  = array_get($input, 'last_name');
        $this->user->email      = array_get($input, 'email');

        $this->user->user_type  = array_get($input, 'user_type');
        $this->user->status     = array_get($input, 'status');

        // if edit
        if ( ! empty($this->user->id) && $this->user->id > 0)
        {
            if (Input::has('password') && trim(array_get($input, 'password')) != "")
            {
                $this->user->password = \Hash::make(array_get($input, 'password'));
            }
        }
        else
        {
            $this->user->password = \Hash::make(array_get($input, 'password'));
        }

        $this->user->save();
        return $this->user;
    }

}