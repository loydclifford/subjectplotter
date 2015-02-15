@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ $page_title }}
    {{ create_back_button(admin_url('/students')) }}

    @if (isset($student))
    <div class="pull-right">
        {{ $student->present()->viewButton() }}
        {{ $student->present()->exportButton() }}
        {{ $student->present()->deleteButton() }}
    </div>
    @endif
</h1>
@overwrite

@section('main-content')

@include('admin._partials._messages')

<?php
$form_rules = array(
        'salutations'           => 'required',
        'first_name'            => 'required',
        'last_name'             => 'required',
        'course_code'           => 'required',
        'course_level_code'     => 'required',
        'email'                 => 'required',
        'password'              => 'required',
        'password_confirmation' => 'required',
);

// Unset password if edit
if (isset($students))
{
    unset($form_rules['password']);
    unset($form_rules['password_confirmation']);
}
?>

{{ Former::vertical_open($url)->method($method)
    ->addClass('col-sm-10 form-check-ays parsley-form')
    ->setAttribute('autocomplete','off')
    ->setAttribute('id','students_update_form')
    ->rules(array(
    'user_id' => 'required',
))
}}

@if (isset($student))
    {{ Former::populate(array_merge($student->toArray(), !empty($student_user) ? $student_user->toArray() : array())) }}
@endif

<div class="row">
    <div class="col-md-6">
        {{ Former::text('student_no', lang('student/attributes.labels.user_id') . ' <span class="required">*</span> ' )
            ->placeholder(lang('student/attributes.placeholders.user_id'))
            ->forceValue(isset($student) ? $student->student_no : $generated_student_no)
            ->setAttributes(isset($student) ? array(
                  'readonly' => 'readonly'
            ) : array()) }}

        {{ Former::text('first_name', lang('student/attributes.labels.first_name') . ' <span class="required">*</span> ' )
            ->placeholder(lang('student/attributes.placeholders.first_name')) }}

        {{ Former::text('last_name', lang('student/attributes.labels.last_name') . ' <span class="required">*</span> ' )
            ->placeholder(lang('student/attributes.placeholders.last_name')) }}

        {{ Former::select('course_code', lang('student/attributes.labels.course') . ' <span class="required">*</span> ' )
            ->placeholder(lang('student/attributes.placeholders.course'))
            ->options(Course::all()->lists('course_code', 'course_code')) }}

        {{ Former::select('course_year_code', lang('student/attributes.labels.year') . ' <span class="required">*</span> ' )
            ->placeholder(lang('student/attributes.placeholders.year'))
            ->options(Student::$year) }}
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-6">
        {{ Former::legend(lang('instructor/texts.legend_login_credentials')) }}

        {{ Former::select('status', lang('instructor/attributes.labels.status') . ' <span class="required">*</span> ' )
            ->placeholder(lang('instructor/attributes.placeholders.status'))
            ->options(User::$statuses) }}

        {{ Former::text('email',lang('student/attributes.labels.email') . ' <span class="required">*</span> ' )
            ->placeholder(lang('student/attributes.placeholders.email')) }}

        @if (isset($student))
            {{ Former::password('password',lang('instructor/attributes.labels.password'))
                ->inlineHelp('Leave empty if you don\'t want to modify student password.')
                ->placeholder(lang('student/attributes.placeholders.password')) }}

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
<br />
<div class="row">
    <div class="col-md-6">
        <div class="buttons">
            {{ create_save_button() }}
            {{ create_cancel_button(admin_url('/students'),lang('texts.cancel_button')) }}
        </div>
    </div>
</div>

<input type="hidden" name="_success_url" value="{{ $success_url }}"/>
<input type="hidden" name="_return_url" value="{{ $return_url }}"/>
{{ Former::close() }}

@stop
