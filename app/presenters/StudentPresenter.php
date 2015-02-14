<?php

class StudentPresenter extends Presenter{

    // Actions Buttons and URLS Presenters

    public function actionButtons()
    {
        ob_start(); ?>
        <div class="btn-group" id="">
            <?php echo $this->editButton() ?>
            <button data-toggle="dropdown" type="button" class="btn btn-info dropdown-toggle">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right text-left">
                <li>
                    <a class="confirm_action" data-message="<?php echo lang('student/texts.delete_confirmation') ?>" href="<?php echo $this->deleteUrl() ?>">
                        <?php echo lang('student/texts.delete') ?>
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
        <a href="<?php echo $this->editUrl() ?>" class="btn btn-primary"><?php echo lang('student/texts.edit') ?></a>
        <?php
        return ob_get_clean();
    }

    public function viewButton()
    {
        ob_start(); ?>
        <a href="<?php echo $this->viewUrl() ?>" class="btn btn-primary"><?php echo lang('student/texts.view') ?></a>
        <?php
        return ob_get_clean();
    }

    public function deleteButton()
    {
        ob_start(); ?>
        <a class="btn btn-warning confirm_action" href="<?php echo $this->deleteUrl() ?>" data-message="<?php echo lang('student/texts.delete_confirmation') ?>">
            <?php echo lang('student/texts.delete') ?>
        </a>
        <?php
        return ob_get_clean();
    }

    public function exportButton()
    {
        ob_start(); ?>
        <a class="btn btn-info" href="<?php echo $this->exportUrl() ?>" target="_blank">
            <?php echo lang('student/texts.export') ?>
        </a>
        <?php
        return ob_get_clean();
    }

    public function deleteUrl()
    {
        $param = array(
            'user_id[]'    => $this->user_id,
            '_token'       => csrf_token(),
            '_success_url' => admin_url('/students'),
        );

        return admin_url("/students/delete/?".http_build_query($param));
    }

    public function exportUrl()
    {
        $param = array(
            'user_id[]' => $this->user_id,
            '_token'    => csrf_token(),
        );

        return admin_url("/students/export/?".http_build_query($param));
    }

    public function editUrl()
    {
        return admin_url("/students/{$this->user_id}/edit");
    }

    public function viewUrl()
    {
        return admin_url("/students/{$this->user_id}/view");
    }

    public function idLink()
    {
        return HTML::link(admin_url("/students/{$this->user_id}/edit"), $this->student_no);
    }

    public function displayNameLink()
    {
        return HTML::link(admin_url("/students/{$this->user_id}/edit"), $this->getDisplayName());
    }
}
