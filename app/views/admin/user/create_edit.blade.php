@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ $page_title }}
    {{ create_back_button(admin_url('/users')) }}

    @if (isset($user))
    <div class="pull-right">
        {{ $user->present()->viewButton() }}
        {{ $user->present()->exportButton() }}
        {{ $user->present()->deleteButton() }}
    </div>
    @endif
</h1>
@overwrite

@section('main-content')

@include('admin._partials._messages')

<?php
    $form_rules = array(
        'salutations'             => 'required',
        'first_name'              => 'Required|Min:3|Max:80|Alpha',
        'last_name'               => 'Required|Min:3|Max:80|Alpha',
        'user_type'               => 'required',
        'status'                  => 'required',
        'address1'                => 'required',
        'country_id'              => 'required',
        'email'                   => 'required|email',
        'password'                => 'required',
        'password_confirmation'   => 'required',
    );

    // Unset password if edit
    if (isset($user))
    {
        unset($form_rules['password']);
        unset($form_rules['password_confirmation']);
    }
?>

{{ Former::vertical_open($url)->method($method)
    ->addClass('col-sm-10 form-check-ays parsley-form')
->setAttribute('autocomplete','off')
->setAttribute('id','users_update_form')
->rules($form_rules)
}}

@if (isset($user))
{{ Former::populate($user->toArray()) }}
@endif

<div class="row">
    <div class="col-md-6">
        {{ Former::text('first_name', lang('user/attributes.labels.first_name') . ' <span class="required">*</span> ' )
            ->placeholder(lang('user/attributes.placeholders.first_name')) }}

        {{ Former::text('last_name', lang('user/attributes.labels.last_name') . ' <span class="required">*</span> ')
            ->placeholder(lang('user/attributes.placeholders.last_name')) }}
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        {{ Former::legend(lang('user/texts.legend_login_credentials')) }}

        {{ Former::text('email',lang('user/attributes.labels.email') . ' <span class="required">*</span> ' )
            ->placeholder(lang('user/attributes.placeholders.email')) }}

        {{ Former::select('status', lang('user/attributes.labels.status') . ' <span class="required">*</span> ' )
            ->placeholder(lang('user/attributes.placeholders.status'))
            ->options(User::$statuses) }}

        @if (isset($user))
        {{ Former::password('password',lang('user/attributes.labels.password'))
            ->inlineHelp(lang('user/texts.new_password_help_text'))
            ->placeholder(lang('user/attributes.placeholders.password')) }}

        {{ Former::password('password_confirmation',lang('user/attributes.labels.password_confirmation'))
            ->placeholder(lang('user/attributes.placeholders.password_confirmation')) }}
        @else
        {{ Former::password('password',lang('user/attributes.labels.password') . ' <span class="required">*</span> ' )
            ->placeholder(lang('user/attributes.placeholders.password')) }}

        {{ Former::password('password_confirmation',lang('user/attributes.labels.password_confirmation') . ' <span class="required">*</span> ' )
            ->placeholder(lang('user/attributes.placeholders.password_confirmation')) }}
        @endif

    </div>
</div>
<br />
<div class="row">
    <div class="col-md-6">
        <div class="buttons">
            {{ create_save_button() }}
            {{ create_cancel_button(admin_url('/users'),lang('texts.cancel_button')) }}
        </div>
    </div>
</div>

<input type="hidden" name="_success_url" value="{{ $success_url }}"/>
<input type="hidden" name="_return_url" value="{{ $return_url }}"/>
<input type="hidden" name="user_type" value="{{ User::USER_TYPE_ADMIN }}"/>
{{ Former::close() }}

@stop