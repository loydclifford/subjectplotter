<?php

function create_back_button($default = NULL, $label = NULL)
{
    $referer = Request::server('HTTP_REFERER');
    $current_url = URL::current();

    $target_link = ( ! is_null($referer) && $current_url != $referer) ? $referer : $default;
    ?>
        <a class="btn btn-default" href="<?php echo $target_link ?>"><?php echo ( ! is_null($label)) ? $label : lang('texts.back_button') ?> </a>
    <?php
}

function create_cancel_button($default = NULL, $label = NULL)
{
    return create_back_button($default,$label);
}

/**
 * Create a simple save button
 *
 * @param null $label
 * @param bool $add_icon (Optional) (Default: False)
 * @param string $loading_icon (Optional) (Default: right) right|left
 */
function create_save_button($label = NULL, $add_icon = false, $loading_icon = "right")
{
    $loading_icon = '<i class="fa fa-spinner fa-5x fa-spin"></i>';

    ?>
    <button class="btn-primary btn-success btn" type="submit">
        <?php if ($loading_icon != 'right') : ?>
            <?php echo $loading_icon ?>
        <?php endif; ?>
        <?php if ($add_icon) : ?>
            <i class="fa fa-plus"></i>
        <?php else : ?>
            <i class="fa fa-save"></i>
        <?php endif; ?>
        <?php echo ( ! is_null($label)) ? $label : lang('texts.save_button') ?>

        <?php if ($loading_icon == 'right') : ?>
            <?php echo $loading_icon ?>
        <?php endif; ?>
    </button>
    <?php
}

function html_image(array $attribute)
{
    $default = array(
        'src' => image_default_url(),
        'alt' => '',
        'title' => ''
    );

    $attribute = array_merge($default,$attribute);
    return "<img ".to_attr($attribute)." />";
}