<?php

class UserPresenter extends Presenter{

    // Presenter
    /**
     * Present full name
     *
     * @return string
     */
    public function getFullName()
    {
        if ($this->first_name || $this->last_name)
        {
            return $this->first_name . ' ' . $this->last_name;
        }
        else
        {
            return '';
        }
    }


    /**
     * Present name
     *
     * @return string
     */
    public function getDisplayName()
    {
        if ($this->getFullName())
        {
            return $this->getFullName();
        }
        else if ($this->email)
        {
            return $this->email;
        }
        else
        {
            return 'Guest';
        }
    }

    public function getDateCreated()
    {
        if ($this->created_at == '0000-00-00 00:00:00' || $this->created_at == '0000-00-00')
        {
            return '---';
        }
        else
        {
            return $this->created_at->format('m/d/y h:i a');
        }
    }

    /**
     * Get current admin profile
     *
     * @return string
     */
    public function getProfileUrl()
    {
        if (can('manage_admin'))
        {
            // when a backend user
            return admin_url("/admin-users/{$this->id}/profile-edit");
        }
        else
        {
            // when frontend
            return url("/users/{$this->id}/account");
        }
    }

    public function getLogoutUrl()
    {
        if (can('manage_admin'))
        {
            // when a backend user
            return admin_url('/logout/?_token='.urlencode(csrf_token()));
        }
        else
        {
            // when frontend
            return url('/logout/?_token='.urlencode(csrf_token()));
        }

    }

    public function getContactDetails()
    {
        $str = '';

        if ($this->first_name || $this->last_name)
        {
            $str .= '<b>' . $this->first_name . ' ' . $this->last_name . '</b><br/>';
        }

        if ($this->email)
        {
            $str .= '<i class="fa fa-envelope" style="width: 20px"></i>' . HTML::mailto($this->email, $this->email) . '<br/>';
        }

        if ($this->phone)
        {
            $str .= '<i class="fa fa-phone" style="width: 20px"></i>' . Utils::formatPhoneNumber($this->phone);
        }

        if ($str)
        {
            $str = '<p>' . $str . '</p>';
        }

        return $str;
    }

    // Actions Buttons and URLS Presenters

    public function actionButtons()
    {
        ob_start(); ?>
        <div class="btn-admin_group" id="">
            <?php echo $this->viewButton() ?>
            <button data-toggle="dropdown" type="button" class="btn btn-info dropdown-toggle">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right text-left">
                <li>
                    <a href="<?php echo $this->editUrl() ?>">
                        <?php echo lang('customer::texts.edit') ?>
                    </a>
                    <a class="confirm_action" data-message="<?php echo lang('customer::texts.delete_confirmation') ?>" href="<?php echo $this->deleteUrl() ?>">
                        <?php echo lang('customer::texts.delete') ?>
                    </a>
                </li>
            </ul>
        </div>
        <?php

        return ob_get_clean();
    }

    public function editButton()
    {
        ob_start(); ?>
        <a href="<?php echo $this->editUrl() ?>" class="btn btn-primary"><?php echo lang('customer::texts.edit') ?></a>
        <?php
        return ob_get_clean();
    }

    public function viewButton()
    {
        ob_start(); ?>
        <a href="<?php echo $this->viewUrl() ?>" class="btn btn-primary"><?php echo lang('customer::texts.view') ?></a>
        <?php
        return ob_get_clean();
    }

    public function deleteButton()
    {
        ob_start(); ?>
        <a class="btn btn-warning confirm_action" href="<?php echo $this->deleteUrl() ?>" data-message="<?php echo lang('customer::texts.delete_confirmation') ?>">
            <?php echo lang('customer::texts.delete') ?>
        </a>
        <?php
        return ob_get_clean();
    }

    public function exportButton()
    {
        ob_start(); ?>
        <a class="btn btn-info" href="<?php echo $this->exportUrl() ?>" target="_blank">
            <?php echo lang('customer::texts.export') ?>
        </a>
        <?php
        return ob_get_clean();
    }

    public function deleteUrl()
    {
        $param = array(
            'users_id[]' => $this->id,
            '_token' => csrf_token(),
            '_success_url' => admin_url('/media'),
        );

        return admin_url("/users/delete/?".http_build_query($param));
    }

    public function exportUrl()
    {
        $param = array(
            'users_id[]' => $this->id,
            '_token' => csrf_token(),
        );

        return admin_url("/users/export/?".http_build_query($param));
    }

    public function editUrl()
    {
        return admin_url("/users/{$this->id}/edit");
    }

    public function viewUrl()
    {
        return admin_url("/users/{$this->id}/view");
    }

    public function idLink()
    {
        return HTML::link(admin_url("/users/{$this->id}/edit"), $this->id);
    }

    public function displayNameLink()
    {
        return HTML::link(admin_url("/users/{$this->id}/edit"), $this->getDisplayName());
    }


}