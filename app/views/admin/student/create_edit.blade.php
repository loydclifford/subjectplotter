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

{{ Former::vertical_open($url)->method($method)
    ->addClass('col-sm-10 form-check-ays parsley-form')
->setAttribute('autocomplete','off')
->setAttribute('id','students_update_form')
->rules(array(
    'student_code' => 'required',
    'student_capacity' => 'required|integer',
))
}}

@if (isset($student))
{{ Former::populate($student->toArray()) }}
@endif

@if (isset($instructor))
    {{ Former::populate(array_merge($instructor->toArray(), !empty($instructor_user) ? $instructor_user->toArray() : array())) }}
@endif

<div class="row">
    <div class="col-md-6">
        {{ Former::text('user_id', lang('student/attributes.labels.user_id') . ' <span class="required">*</span> ' )
            ->placeholder(lang('student/attributes.placeholders.user_id'))
            ->forceValue(isset($instructor) ? $instructor->id : $generated_instructor_id)
            ->setAttributes(isset($instructor) ? array(
                  'readonly' => 'readonly'
            ) : array()) }}

        {{ Former::text('first_name', lang('student/attributes.labels.first_name') . ' <span class="required">*</span> ' )
            ->placeholder(lang('student/attributes.placeholders.first_name')) }}

        {{ Former::text('last_name', lang('student/attributes.labels.last_name') . ' <span class="required">*</span> ' )
            ->placeholder(lang('student/attributes.placeholders.last_name')) }}

        {{ Former::select('course', lang('student/attributes.labels.course') . ' <span class="required">*</span> ' )
            ->placeholder(lang('student/attributes.placeholders.course'))
            ->options(Course::all()->lists('course_code')) }}

        {{ Former::select('year', lang('student/attributes.labels.year') . ' <span class="required">*</span> ' )
            ->placeholder(lang('student/attributes.placeholders.year'))
            ->options(Student::$year) }}

        {{ Former::text('email', lang('student/attributes.labels.email') . ' <span class="required">*</span> ')
            ->placeholder(lang('student/attributes.placeholders.email')) }}

        {{ Former::password('password', lang('student/attributes.labels.password') . ' <span class="required">*</span> ')
            ->placeholder(lang('student/attributes.placeholders.password')) }}

        {{ Former::password('confirmed_password', lang('student/attributes.labels.confirmed_password') . ' <span class="required">*</span> ')
            ->placeholder(lang('student/attributes.placeholders.confirmed_password')) }}
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
