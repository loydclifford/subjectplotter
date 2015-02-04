@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ $page_title }}
    {{ create_back_button(admin_url('/instructors')) }}

    @if (isset($instructor))
    <div class="pull-right">
        {{ $instructor->present()->viewButton() }}
        {{ $instructor->present()->exportButton() }}
        {{ $instructor->present()->deleteButton() }}
    </div>
    @endif
</h1>
@overwrite

@section('main-content')

@include('admin._partials._messages')

<?php
    $form_rules = array(
        'salutations' => 'required',
        'first_name'  => 'required',
        'instructor_type'   => 'required',
        'status'   => 'required',
        'address1'   => 'required',
        'country_id'   => 'required',
        'email'   => 'required',
        'password'   => 'required',
        'password_confirmation'   => 'required',
    );

    // Unset password if edit
    if (isset($instructor))
    {
        unset($form_rules['password']);
        unset($form_rules['password_confirmation']);
    }
?>

{{ Former::vertical_open($url)->method($method)
    ->addClass('col-sm-10 form-check-ays parsley-form')
->setAttribute('autocomplete','off')
->setAttribute('id','instructors_update_form')
->rules($form_rules)
}}

@if (isset($instructor))
{{ Former::populate($instructor->toArray()) }}
@endif

<div class="row">
    <div class="col-md-6">
        {{ Former::text('first_name', lang('instructor/attributes.labels.first_name') . ' <span class="required">*</span> ' )
            ->placeholder(lang('instructor/attributes.placeholders.first_name')) }}

        {{ Former::text('last_name', lang('instructor/attributes.labels.last_name') . ' <span class="required">*</span> ')
            ->placeholder(lang('instructor/attributes.placeholders.last_name')) }}
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        {{ Former::legend(lang('instructor/texts.legend_login_credentials')) }}

        {{ Former::text('email',lang('instructor/attributes.labels.email') . ' <span class="required">*</span> ' )
            ->placeholder(lang('instructor/attributes.placeholders.email')) }}

        {{ Former::select('status', lang('instructor/attributes.labels.status') . ' <span class="required">*</span> ' )
            ->placeholder(lang('instructor/attributes.placeholders.status'))
            ->options(User::$statuses) }}

        @if (isset($instructor))
        {{ Former::password('password',lang('instructor/attributes.labels.password'))
            ->inlineHelp(lang('instructor/texts.new_password_help_text'))
            ->placeholder(lang('instructor/attributes.placeholders.password')) }}

        {{ Former::password('password_confirmation',lang('instructor/attributes.labels.password_confirmation'))
            ->placeholder(lang('instructor/attributes.placeholders.password_confirmation')) }}
        @else
        {{ Former::password('password',lang('instructor/attributes.labels.password') . ' <span class="required">*</span> ' )
            ->placeholder(lang('instructor/attributes.placeholders.password')) }}

        {{ Former::password('password_confirmation',lang('instructor/attributes.labels.password_confirmation') . ' <span class="required">*</span> ' )
            ->placeholder(lang('instructor/attributes.placeholders.password_confirmation')) }}
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        {{ Former::legend(lang('instructor/texts.legend_login_credentials')) }}

        <div class="row instructor-subject-categories">
            @foreach(SubjectCategory::all() as $subject_category)
                <div class="instructor-subject-category__item col-sm-4">
                    <label>
                        {{ Form::checkbox('subject_category_[]', $subject_category->id, in_array($subject_category->id, $selected_subject_categories), array(
                            'data-parsley-mincheck' => 1,
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
            {{ create_cancel_button(admin_url('/instructors'),lang('texts.cancel_button')) }}
        </div>
    </div>
</div>

<input type="hidden" name="_success_url" value="{{ $success_url }}"/>
<input type="hidden" name="_return_url" value="{{ $return_url }}"/>
<input type="hidden" name="instructor_type" value="{{ User::USER_TYPE_ADMIN }}"/>
{{ Former::close() }}

@stop