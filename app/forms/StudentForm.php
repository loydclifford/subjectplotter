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
            'student_code'          => 'required|unique:students,student_code',
            'student_name'          => 'required',
            'units'                 => 'required',
            'description'           => '',
            'prerequisite'          => 'required',
            'student_category_code' => 'required',
        );

        // If Edit
        if ( ! empty($this->model->student_code))
        {
            // We don't want to
            if ($this->model->student_code == array_get($input, 'student_code'))
            {
                unset($rules['student_code']);
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
     * @param null $input
     * @return Student|User
     */
    public function saveInput($input = null)
    {
        $input = ! empty($input) ? $input : Input::all();

        // Do a security check  // Do save
        $this->model->student_code          = array_get($input, 'student_code');
        $this->model->student_name          = array_get($input, 'student_name');
        $this->model->units                 = array_get($input, 'units');
        $this->model->description           = array_get($input, 'description');
        $this->model->prerequisite          = array_get($input, 'prerequisite');
        $this->model->student_category_code = array_get($input, 'student_category_code');

        // if edit
        $this->model->save();
        return $this->model;
    }
}
