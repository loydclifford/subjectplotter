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
            'instructor_id'         => 'required|unique:instructors,id',
            'email'                 => 'required|email|unique:users,email',
            'first_name'            => 'required',
            'last_name'             => 'required',
            'password'			    => 'password|required',
            'password_confirmation' => 'same:password|required',
            'status'                => 'required',
        );

        // If Edit
        if ( ! empty($this->model->id))
        {
            // We don't want to
            if ($this->model->user)
            {
                if ($this->model->user->email == array_get($input, 'email'))
                {
                    unset($rules['email']);
                }
            }

            // Another condition if edit
            $rules['instructor_id'] = 'required|exists:instructors,id';

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
     * Save validated inputs
     *
     * @param null $input
     * @return Instructor|User
     */
    public function saveInput($input = null)
    {
        $input = ! empty($input) ? $input : Input::all();

        $user = $this->model->user;

        if ( ! $user)
        {
            $user = new User();
        }

        $user->first_name = array_get($input, 'first_name');
        $user->last_name  = array_get($input, 'last_name');
        $user->email      = array_get($input, 'email');
        $user->user_type  = User::USER_TYPE_INSTRUCTOR;
        $user->status     = array_get($input, 'status');

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

        // save instructor and his associated user account
        $user->save();

        // Do a security check  // Do save
        $this->model->id      = array_get($input, 'instructor_id');
        $this->model->user_id = $user->id;
        $this->model->save();

        // Save instructor subject category
        // delete old data
        InstructorSubjectCategory::where('instructor_id', $this->model->id)->delete();
        foreach (Input::get('subject_category_code', array()) as $subject_code)
        {
            InstructorSubjectCategory::insert(array(
                'subject_category_code' => $subject_code,
                'instructor_id' => $this->model->id,
            ));
        }

        return $this->model;
    }
}
