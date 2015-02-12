<?php

class SubjectForm {

    /**
     * User class instance
     *
     * @var User
     */
    protected $model;

    /**
     * Create instance of UserRepo
     *
     * @param Subject $subject
     */
    public function __construct(Subject $subject)
    {
        $this->model = $subject;
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
            'subject_code'          => 'required|unique:subjects,subject_code',
            'subject_name'          => 'required',
            'units'                 => 'required',
            'description'           => '',
            'prerequisite'          => 'required',
            'subject_category_code' => 'required|unique',
        );

        // If Edit
        if ( ! empty($this->model->subject_code))
        {
            // We don't want to
            if ($this->model->subject_code == array_get($input, 'subject_code'))
            {
                unset($rules['subject_code']);
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
     * @return Subject|User
     */
    public function saveInput($input = null)
    {
        $input = ! empty($input) ? $input : Input::all();

        // Do a security check  // Do save
        $this->model->subject_code          = array_get($input, 'subject_code');
        $this->model->subject_name          = array_get($input, 'subject_name');
        $this->model->units                 = array_get($input, 'units');
        $this->model->description           = array_get($input, 'description');
        $this->model->prerequisite          = array_get($input, 'prerequisite');
        $this->model->subject_category_code = array_get($input, 'subject_category_code');

        // if edit
        $this->model->save();
        return $this->model;
    }
}
