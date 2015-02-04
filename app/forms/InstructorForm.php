<?php

class InstructorForm {

    /**
     * User class instance
     *
     * @var User
     */
    protected $model;

    /**
     * Create instance of UserRepo
     *
     * @param Instructor $instructor
     */
    public function __construct(Instructor $instructor)
    {
        $this->model = $instructor;
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
            'user_id'                => 'required|unique:users,id',

            'first_name'                => 'required',
            'last_name'                 => '',
            'password'			        => 'password|required',
            'password_confirmation' 	=> 'same:password|required',
            'email'                     => 'required|email|unique:users,email',
            'status'                     => 'required',
        );

        // If Edit
        if ( ! empty($this->model->id))
        {
            // We don't want to
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
        $this->model->user_id           = array_get($input, 'user_id');

        $user = $this->model->user;

        if ( ! $user)
        {
            $user = new User();
        }

        $user->first_name           = array_get($input, 'first_name');
        $user->last_name            = array_get($input, 'last_name');
        $user->email                = array_get($input, 'email');

        $user->user_type                = array_get($input, 'user_type');
        $user->status                = array_get($input, 'status');

        // if edit
        if ( ! empty($user->id) && $user->id > 0)
        {
            if (Input::has('password') && trim(array_get($input, 'password')) != "")
            {
                $user->password = \Hash::make(array_get($input, 'password'));
            }
        }
        else
        {
            $user->password = \Hash::make(array_get($input, 'password'));
        }

        $user->save();

        // if edit

        $this->model->save();
        return $this->model;
    }

}