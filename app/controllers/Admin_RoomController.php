<?php

class Admin_RoomController extends Admin_BaseController {

    public function getIndex()
    {
        // Lists
        $list = new RoomTblist();
        $list->prepareList();

        if (Request::ajax())
        {
            return $list->toJson();
        }

        $this->data['meta']->title  = lang('room/texts.meta_title');
        $this->data['list']         = $list;
        $this->data['list_action']         = '#';

        return View::make('admin.room.index', $this->data);
    }

    public function getCreate()
    {
        // Meta Data
        $this->data['meta']->title  = lang('room/texts.create_meta_title');
        $this->data['page_title']   = lang('room/texts.create_page_title');

        // Form data
        $this->data['url']           = URL::current();
        $this->data['method']        = 'POST';
        $this->data['return_url']    = admin_url('/rooms/create');
        $this->data['success_url']   = admin_url('/rooms');

        return View::make('admin.room.create_edit')->with($this->data);
    }

    public function postCreate()
    {
        // Check for taxonomy slugs
        $room_repo = new RoomForm(new Room());
        if ($has_error = $room_repo->validateInput())
        {
            return $has_error;
        }

        $room = $room_repo->saveInput();
        Event::fire('room.add', $room);

        return Redirect::to(Input::get('_success_url'))
            ->with(SUCCESS_MESSAGE,lang('room/texts.create_success'));
    }

    public function getEdit(Room $room)
    {
        $this->data['meta']->title  = lang('room/texts.update_meta_title');
        $this->data['page_title']   = lang('room/texts.update_page_title');

        $this->data['url']          = URL::current();
        $this->data['method']       = 'POST';
        $this->data['return_url']   = admin_url("/rooms/{$room->room_id}/edit");
        $this->data['success_url']  = admin_url("/rooms/{$room->room_id}/edit");

        $this->data['enable_breadcrumb']   = false;
        $this->data['room']         = $room;

        return View::make('admin.room.create_edit')->with($this->data);
    }

    public function postEdit(Room $room)
    {
        // Check for taxonomy slugs
        $room_repo = new RoomForm($room);
        if ($has_error = $room_repo->validateInput())
        {
            return $has_error;
        }

        $room = $room_repo->saveInput();
        Event::fire('room.update', $room);

        return Redirect::to(admin_url("rooms/{$room->room_id}/edit"))
            ->with(SUCCESS_MESSAGE,lang('room/texts.update_success'));
    }

    public function getDelete()
    {
        Utils::validateBulkArray('rooms_id');
        // The room id56665`
        $rooms_ids = Input::get('rooms_id', array());
        $rooms = Room::whereIn('room_id', $rooms_ids);
        // Delete Rooms
        Event::fire('room.delete', $rooms);
        $rooms->delete();

        if (Input::has('_success_url'))
        {
            return \Redirect::to(Input::get('_success_url'))
                ->with(SUCCESS_MESSAGE, lang('room/texts.delete_success'));
        }
        else
        {
            return Redirect::back()
                ->with(SUCCESS_MESSAGE, lang('room/texts.delete_success'));
        }
    }

    // Import

    public function getExport()
    {
        Utils::validateBulkArray('rooms_id');

        $array = Room::whereIn('id',Input::get('rooms_id'))->get()->toArray();

        // Start export if not empty
        if ( ! empty($array))
        {
            $headers = array_keys($array[0]);
            Utils::csvDownload('rooms_data_csv', $array, $headers);
        }
    }

    // Select 2 Search Room
    public function getSearchSelect()
    {
        if (Input::has('method') && Input::get('method') == "init-selection"){
            $room = Room::frontEndGroups()->find(Input::get('id'));

            if($room)
            {
                $ret['id']          = $room->room_id;
                $ret['first_name']  = $room->first_name;
                $ret['last_name']   = $room->last_name;
                $ret['email']       = $room->email;

                return Response::json($ret);
            }

            return Response::json(array());
        }

        $per_page   = Input::get('per_page');
        $page       = Input::get('page');
        $offset     = ($page - 1 ) * $per_page;
        $queue      = trim(Input::get('q'));

        // generate the query
        if (is_numeric($queue))
        {
            // If numeric, then it is id that the room is
            // intended to search
            $rooms = Room::where('id', $queue);
        }
        else
        {
            // If string, then it is a name that the room is
            // intended to search
            $rooms = Room::frontEndGroups()->where(function($query) use ($queue) {
                $query->where('first_name', 'LIKE', $queue . '%');
                $query->orWhere('last_name', 'LIKE', $queue . '%');
            });
        }

        $results = $rooms->skip($offset)
            ->take($per_page)
            ->get();

        $ret = array(
            'total' => $rooms->count()
        );

        $room_assoc = array();
        foreach($results as $room) {
            $room_assoc[] = array(
                'id'            => $room->room_id,
                'first_name'     => $room->first_name,
                'last_name'      =>$room->last_name,
                'email'         => $room->email
            );
        }

        $ret['rooms'] = $room_assoc;

        return Response::json($ret);
    }


}