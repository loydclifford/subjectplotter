<?php

class CoursePresenter extends Presenter{


    // Actions Buttons and URLS Presenters
    public function getShortDescription()
    {
        return Str::limit($this->description, 49);
    }

    public function actionButtons()
    {
        ob_start(); ?>
        <div class="btn-group" id="">
            <?php echo $this->viewButton() ?>
            <button data-toggle="dropdown" type="button" class="btn btn-info dropdown-toggle">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right text-left">
                <li>
                    <a class="" data-message="" href="<?php echo $this->editUrl() ?>">
                        <?php echo lang('course/texts.edit') ?>
                    </a>
                    <a class="confirm_action" data-message="<?php echo lang('course/texts.delete_confirmation') ?>" href="<?php echo $this->deleteUrl() ?>">
                        <?php echo lang('course/texts.delete') ?>
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
        <a href="<?php echo $this->editUrl() ?>" class="btn btn-primary"><?php echo lang('course/texts.edit') ?></a>
        <?php
        return ob_get_clean();
    }

    public function viewButton()
    {
        ob_start(); ?>
        <a href="<?php echo $this->viewUrl() ?>" class="btn btn-primary"><?php echo lang('course/texts.view') ?></a>
        <?php
        return ob_get_clean();
    }

    public function deleteButton()
    {
        ob_start(); ?>
        <a class="btn btn-warning confirm_action" href="<?php echo $this->deleteUrl() ?>" data-message="<?php echo lang('course/texts.delete_confirmation') ?>">
            <?php echo lang('course/texts.delete') ?>
        </a>
        <?php
        return ob_get_clean();
    }

    public function exportButton()
    {
        ob_start(); ?>
        <a class="btn btn-info" href="<?php echo $this->exportUrl() ?>" target="_blank">
            <?php echo lang('course/texts.export') ?>
        </a>
        <?php
        return ob_get_clean();
    }

    public function deleteUrl()
    {
        $param = array(
            'course_codes[]'=> $this->course_code,
            '_token'       => csrf_token(),
            '_success_url' => admin_url('/courses'),
        );

        return admin_url("/courses/delete/?".http_build_query($param));
    }

    public function exportUrl()
    {
        $param = array(
            'course_codes[]' => $this->course_code,
            '_token' => csrf_token(),
        );

        return admin_url("/courses/export/?".http_build_query($param));
    }

    public function editUrl()
    {
        return admin_url("/courses/{$this->course_code}/edit");
    }

    public function viewUrl()
    {
        return admin_url("/courses/{$this->course_code}/view");
    }

    public function idLink()
    {
        return HTML::link(admin_url("/courses/{$this->course_code}/edit"), $this->course_code);
    }

    public function displayNameLink()
    {
        return HTML::link(admin_url("/courses/{$this->course_code}/edit"), $this->getDisplayName());
    }


}