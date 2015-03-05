<?php

class StudentForm {

    /**
     * User class instance
     *
     * @var User
     */
    protected $model;

    /**
     * Create instance of UserRepo
     *
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        $this->model = $student;
    }

    /**
     * Validate Submitted form
     *
     * @param null $input
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function validateInput($input = null)
    {
        // do validation
        $input = ! empty($input) ? $input : Input::all();
        $return_url = array_get($input, '_return_url');

        // Default rules
        $rules = array(
            'student_no'            => 'required|unique:students,student_no|Integer|Min:12',
            'first_name'            => 'Required|Min:3|Max:80|Alpha',
            'last_name'             => 'Required|Min:3|Max:80|Alpha',
            'status'                => 'required',
            'course_code'           => 'required|exists:courses,course_code',
            'course_year_code'      => 'required',
            'email'                 => 'required|unique:users,email|Email',
            'password'              => 'Required|AlphaNum|Between:4,8',
            'password_confirmation' => 'Required|AlphaNum|Between:4,8|same:password',
        );

        // If Edit
        if ( ! empty($this->model->student_no))
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
            $rules['student_no'] = 'required|exists:students,student_no';

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
                ->with(ERROR_MESSAGE, "Please correct the error below.");
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
     * @param null $input
     * @return Student|User
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
        $user->user_type  = User::USER_TYPE_STUDENT;
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

        // Do a security check
        $this->model->student_no    = array_get($input, 'student_no');
        $this->model->user_id       = $user->id;
        $this->model->course_code   = array_get($input, 'course_code');
        $this->model->course_year_code = array_get($input, 'course_year_code');
        $this->model->save();

        return $this->model;
    }
}
