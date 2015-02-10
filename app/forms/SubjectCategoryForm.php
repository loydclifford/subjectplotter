<?php

class SubjectCategoryForm {

    /**
     * User class instance
     *
     * @var User
     */
    protected $model;

    /**
     * Create instance of UserRepo
     *
     * @param SubjectCategory $subject_categories
     */
    public function __construct(SubjectCategory $subject_categories)
    {
        $this->model = $subject_categories;
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
            'subject_category_code' => 'required|unique:subject_category,subject_category_code',
            'subject_category_name' => 'required|unique:subject_category,subject_category_name',
        );

        // If Edit
        if ( ! empty($this->model->subject_category_code))
        {
            // We don't want to
            if ($this->model->subject_category_code == array_get($input, 'subject_category_code'))
            {
                unset($rules['subject_category_code']);
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
        $this->model->subject_category_code         = array_get($input, 'subject_category_code');
        $this->model->subject_category_name          = array_get($input, 'subject_category_name');

        // if edit

        $this->model->save();
        return $this->model;
    }
}
