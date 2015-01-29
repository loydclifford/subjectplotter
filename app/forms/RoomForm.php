<?php

class RoomForm {

    /**
     * User class instance
     *
     * @var User
     */
    protected $model;

    /**
     * Create instance of UserRepo
     *
     * @param Room $room
     */
    public function __construct(Room $room)
    {
        $this->model = $room;
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
            'room_id'                => 'required|unique:rooms,room_id',
            'description'            => '',
            'room_capacity'			 => 'integer',
        );

        // If Edit
        if ( ! empty($this->model->room_id))
        {
            // We don't want to
            if ($this->model->room_id == array_get($input, 'room_id'))
            {
                unset($rules['room_id']);
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
        $this->model->room_id           = array_get($input, 'room_id');
        $this->model->description            = array_get($input, 'description');
        $this->model->room_capacity                = array_get($input, 'room_capacity');

        // if edit

        $this->model->save();
        return $this->model;
    }

}