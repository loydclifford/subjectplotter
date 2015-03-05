
@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ $page_title }}
    {{ create_back_button(admin_url('/deans')) }}

    @if (isset($dean))
    <div class="pull-right">
        {{ $dean->present()->viewButton() }}
        {{ $dean->present()->exportButton() }}
        {{ $dean->present()->deleteButton() }}
    </div>
    @endif
</h1>
@overwrite

@section('main-content')

@include('admin._partials._messages')

<?php
    $form_rules = array(
        'salutations'           => 'required',
        'first_name'            => 'Required|Min:3|Max:80|Alpha',
        'last_name'             => 'Required|Min:3|Max:80|Alpha',
        'dean_type'       => 'required',
        'status'                => 'required',
        'address1'              => 'required',
        'country_id'            => 'required',
        'email'                 => 'required|Email',
        'password'              => 'required',
        'password_confirmation' => 'required',
    );

    // Unset password if edit
    if (isset($dean))
    {
        unset($form_rules['password']);
        unset($form_rules['password_confirmation']);
    }
?>

{{ Former::vertical_open($url)->method($method)
    ->addClass('col-sm-10 form-check-ays parsley-form')
    ->setAttribute('autocomplete','off')
    ->setAttribute('id','deans_update_form')
    ->rules($form_rules)
}}

@if (isset($dean))
{{ Former::populate(array_merge($dean->toArray(), !empty($dean_user) ? $dean_user->toArray() : array())) }}
@endif

<div class="row">
    <div class="col-md-6">

        {{ Former::text('dean_id', lang('dean/attributes.labels.dean_id') . ' <span class="required">*</span> ' )
            ->placeholder(lang('dean/attributes.placeholders.dean_id'))
            ->forceValue(isset($dean) ? $dean->id : $generated_dean_id)
            ->setAttributes(isset($dean) ? array(
                  'readonly' => 'readonly'
            ) : array()) }}

        {{ Former::text('first_name', lang('dean/attributes.labels.first_name') . ' <span class="required">*</span> ' )
            ->placeholder(lang('dean/attributes.placeholders.first_name')) }}

        {{ Former::text('last_name', lang('dean/attributes.labels.last_name') . ' <span class="required">*</span> ')
            ->placeholder(lang('dean/attributes.placeholders.last_name')) }}
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-6">
        {{ Former::legend(lang('dean/texts.legend_login_credentials')) }}

        {{ Former::text('email',lang('dean/attributes.labels.email') . ' <span class="required">*</span> ' )
            ->placeholder(lang('dean/attributes.placeholders.email')) }}

        {{ Former::select('status', lang('dean/attributes.labels.status') . ' <span class="required">*</span> ' )
            ->placeholder(lang('dean/attributes.placeholders.status'))
            ->options(User::$statuses) }}

        @if (isset($dean))
        {{ Former::password('password',lang('dean/attributes.labels.password'))
            ->inlineHelp(lang('dean/texts.new_password_help_text'))
            ->placeholder(lang('dean/attributes.placeholders.password')) }}

        {{ Former::password('password_confirmation',lang('dean/attributes.labels.password_confirmation'))
            ->placeholder(lang('dean/attributes.placeholders.password_confirmation')) }}
        @else
        {{ Former::password('password',lang('dean/attributes.labels.password') . ' <span class="required">*</span> ' )
            ->placeholder(lang('dean/attributes.placeholders.password')) }}

        {{ Former::password('password_confirmation',lang('dean/attributes.labels.password_confirmation') . ' <span class="required">*</span> ' )
            ->placeholder(lang('dean/attributes.placeholders.password_confirmation')) }}
        @endif
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <legend> Dean Subjects Category</legend>
        <div class="row dean-subject-categories form-group">
            @foreach(SubjectCategory::all() as $subject_category)
                <div class="dean-subject-category__item col-sm-3">
                    <label>
                        {{ Form::checkbox('subject_category_code[]', $subject_category->subject_category_code, in_array($subject_category->subject_category_code, Input::old('subject_category_code', $selected_subject_categories)), array(
                            'data-parsley-mincheck' => 1,
                            'required' => 'required',
                        )) }}

                        {{ $subject_category->subject_category_name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>

<br />
<div class="row">
    <div class="col-md-6">
        <div class="buttons">
            {{ create_save_button() }}
            {{ create_cancel_button(admin_url('/deans'),lang('texts.cancel_button')) }}
        </div>
    </div>
</div>

<input type="hidden" name="_success_url" value="{{ $success_url }}"/>
<input type="hidden" name="_return_url" value="{{ $return_url }}"/>
<input type="hidden" name="dean_type" value="{{ User::USER_TYPE_ADMIN }}"/>
{{ Former::close() }}

@stop