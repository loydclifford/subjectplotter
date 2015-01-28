<?php
if ( ! empty($message_prefix))
{
    $message_prefix = $message_prefix;
}
else
{
    $message_prefix = NULL;
}
?>

@if (Session::has($message_prefix . SUCCESS_MESSAGE))
    <div class="alert alert-small alert-success fade in">
        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
        <i class="fa fa-check mr-5px"></i>
        {{ Session::get($message_prefix . SUCCESS_MESSAGE) }}
    </div>
@endif

@if (Session::has($message_prefix . ERROR_MESSAGE))
    <div class="alert alert-small alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="fa fa-info-circle"></i>
        {{ Session::get($message_prefix . ERROR_MESSAGE) }}
    </div>
@endif