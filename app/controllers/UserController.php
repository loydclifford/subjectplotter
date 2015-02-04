<?php

class UserController extends BaseController {
    
    public function getTest()
    {
        $user = User::find(502);
        echo $user->first_name; echo "<br />";
        echo $user->present()->getCreatedAt(); echo "<br />";
        echo $user->present()->getStatus(); echo "<br />";
        var_dump($user); 
    }

    public function getIndex()
    {
        // Lists
        $list = new UserTblist();
        $list->prepareList();

        if (Request::ajax())
        {
            return $list->toJson();
        }

        $this->data['meta']->title  = lang('user/texts.meta_title');
        $this->data['list']         = $list;
        $this->data['list_action']         = '#';

        return View::make('admin.user.index', $this->data);
    }

    public function getCreate()
    {
        // Meta Data
        $this->data['meta']->title  = lang('user/texts.create_meta_title');
        $this->data['page_title']   = lang('user/texts.create_page_title');

        // Form data
        $this->data['url']           = URL::current();
        $this->data['method']        = 'POST';
        $this->data['return_url']    = admin_url('/users/create');
        $this->data['success_url']   = admin_url('/users');

        return View::make('admin.user.create_edit')->with($this->data);
    }

    public function postCreate()
    {
        // Check for taxonomy slugs
        $user_repo = new UserForm(new User());
        if ($has_error = $user_repo->validateInput())
        {
            return $has_error;
        }

        $user = $user_repo->saveInput();
        Event::fire('user.add', $user);

        return Redirect::to(Input::get('_success_url'))
            ->with(SUCCESS_MESSAGE,lang('user/texts.create_success'));
    }

    public function getEdit(User $user)
    {
        $this->data['meta']->title  = lang('user/texts.update_meta_title');
        $this->data['page_title']   = lang('user/texts.update_page_title');

        $this->data['url']          = URL::current();
        $this->data['method']       = 'POST';
        $this->data['return_url']   = admin_url("/users/{$user->id}/edit");
        $this->data['success_url']  = admin_url("/users/{$user->id}/edit");

        $this->data['enable_breadcrumb']   = false;
        $this->data['user']         = $user;

        return View::make('admin.user.create_edit')->with($this->data);
    }

    public function postEdit(User $user)
    {
        // Check for taxonomy slugs
        $user_repo = new UserForm($user);
        if ($has_error = $user_repo->validateInput())
        {
            return $has_error;
        }

        $user = $user_repo->saveInput();
        Event::fire('user.update', $user);

        return Redirect::to(Input::get('_success_url'))
            ->with(SUCCESS_MESSAGE,lang('user/texts.update_success'));
    }

    public function getView(User $user)
    {
        $this->data['meta']->title  = lang('user/texts.view_meta_title');

        $this->data['enable_breadcrumb']    = false;
        $this->data['user']                 = $user;

        // User List
        $listing_list = new ListingTblist($user->id, true);
        $listing_list->setBaseURL(admin_url('/listings'), array(
            'hide_user_search' => true
        ));
        $listing_list->prepareList();
        $this->data['listing_list']           = $listing_list;
        $this->data['listing_list_action']    = $listing_list->getBaseURL();

        // Order Tblist
        $order_list = new OrderTblist($user->id, true);
        $order_list->setBaseURL(admin_url('/orders'), array(
            'hide_user_search' => true
        ));
        $order_list->prepareList();
        $this->data['order_list']           = $order_list;
        $this->data['order_list_action']    = $order_list->getBaseURL();

        // Listing Tblist
        $listing_enquiry_list = new ListingEnquiryTblist($user->id, true);
        $listing_enquiry_list->setBaseURL(admin_url('/listing-enquiries'), array(
            'hide_user_search' => true
        ));
        $listing_enquiry_list->prepareList();
        $this->data['listing_enquiry_list']         = $listing_enquiry_list;
        $this->data['listing_enquiry_action']       = $listing_enquiry_list->getBaseURL();

        return View::make('admin.user.view')->with($this->data);
    }

    public function getDelete()
    {
        Utils::validateBulkArray('users_id');

        // The user id56665`
        $users_ids = Input::get('users_id', array());
        $users = User::whereIn('id', $users_ids)->get();
        // Delete Users
        Event::fire('user.delete', $users);
        $users->delete();

        if (Input::has('_success_url'))
        {
            return \Redirect::to(Input::get('_success_url'))
                ->with(SUCCESS_MESSAGE, lang('user/texts.delete_success'));
        }
        else
        {
            return Redirect::back()
                ->with(SUCCESS_MESSAGE, lang('user/texts.delete_success'));
        }
    }

    // Import

    public function getExport()
    {
        Utils::validateBulkArray('users_id');

        $array = User::whereIn('id',Input::get('users_id'))->get()->toArray();

        // Start export if not empty
        if ( ! empty($array))
        {
            $headers = array_keys($array[0]);
            Utils::csvDownload('users_data_csv', $array, $headers);
        }
    }

    // Select 2 Search User
    public function getSearchSelect()
    {
        if (Input::has('method') && Input::get('method') == "init-selection"){
            $user = User::frontEndGroups()->find(Input::get('id'));

            if($user)
            {
                $ret['id']          = $user->id;
                $ret['first_name']  = $user->first_name;
                $ret['last_name']   = $user->last_name;
                $ret['email']       = $user->email;

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
            // If numeric, then it is id that the user is
            // intended to search
            $users = User::where('id', $queue);
        }
        else
        {
            // If string, then it is a name that the user is
            // intended to search
            $users = User::frontEndGroups()->where(function($query) use ($queue) {
                $query->where('first_name', 'LIKE', $queue . '%');
                $query->orWhere('last_name', 'LIKE', $queue . '%');
            });
        }

        $results = $users->skip($offset)
            ->take($per_page)
            ->get();

        $ret = array(
            'total' => $users->count()
        );

        $user_assoc = array();
        foreach($results as $user) {
            $user_assoc[] = array(
                'id'            => $user->id,
                'first_name'     => $user->first_name,
                'last_name'      =>$user->last_name,
                'email'         => $user->email
            );
        }

        $ret['users'] = $user_assoc;

        return Response::json($ret);
    }


}