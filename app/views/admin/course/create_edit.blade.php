@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ $page_title }}
    {{ create_back_button(admin_url('/courses')) }}

    @if (isset($course))
    <div class="pull-right">
        {{ $course->present()->viewButton() }}
        {{ $course->present()->exportButton() }}
        {{ $course->present()->deleteButton() }}
    </div>
    @endif
</h1>
@overwrite

@section('main-content')

@include('admin._partials._messages')

{{ Former::vertical_open($url)->method($method)
    ->addClass('col-sm-10 form-check-ays parsley-form')
->setAttribute('autocomplete','off')
->setAttribute('id','courses_update_form')
->rules(array(
    'course_code' => 'required',
    'course_capacity' => 'required|integer',
))
}}

@if (isset($course))
{{ Former::populate($course->toArray()) }}
@endif

<div class="row">
    <div class="col-md-6">
        {{ Former::text('course_code', lang('course/attributes.labels.course_code') )
            ->placeholder(lang('course/attributes.placeholders.course_code')) }}

        {{ Former::textarea('description', lang('course/attributes.labels.description'))
            ->placeholder(lang('course/attributes.placeholders.description')) }}

    </div>

</div>

<br />
<div class="row">
    <div class="col-md-6">
        <div class="buttons">
            {{ create_save_button() }}
            {{ create_cancel_button(admin_url('/courses'),lang('texts.cancel_button')) }}
        </div>
    </div>
</div>

<input type="hidden" name="_success_url" value="{{ $success_url }}"/>
<input type="hidden" name="_return_url" value="{{ $return_url }}"/>
{{ Former::close() }}

@stop