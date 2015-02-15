<?php

class Room extends Eloquent {

    // Presenter
    use PresentableTrait;
    protected $presenter = 'RoomPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms';
    protected $primaryKey = 'room_id';

    public $incrementing = false;
    public $timestamps = false;
}
