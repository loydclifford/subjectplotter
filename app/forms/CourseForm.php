<?php

class CourseForm {

    /**
     * User class instance
     *
     * @var User
     */
    protected $model;

    /**
     * Create instance of UserRepo
     *
     * @param Course $course
     */
    public function __construct(Course $course)
    {
        $this->model = $course;
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
            'course_code'                => 'required|unique:courses,course_code',
            'description'            => '',
        );

        // If Edit
        if ( ! empty($this->model->course_code))
        {
            // We don't want to
            if ($this->model->course_code == array_get($input, 'course_code'))
            {
                unset($rules['course_code']);
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
        $this->model->course_code           = array_get($input, 'course_code');
        $this->model->description            = array_get($input, 'description');

        // if edit

        $this->model->save();
        return $this->model;
    }

}