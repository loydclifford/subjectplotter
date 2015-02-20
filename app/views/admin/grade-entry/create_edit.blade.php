@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ $page_title }}
    {{ create_back_button(admin_url('/subjects/categories')) }}

    @if (isset($subjectcategory))
    <div class="pull-right">
        {{ $subjectcategory->present()->viewButton() }}
        {{ $subjectcategory->present()->exportButton() }}
        {{ $subjectcategory->present()->deleteButton() }}
    </div>
    @endif
</h1>
@overwrite

@section('main-content')

@include('admin._partials._messages')

{{ Former::vertical_open($url)->method($method)
    ->addClass('col-sm-10 form-check-ays parsley-form')
    ->setAttribute('autocomplete','off')
    ->setAttribute('id','')
    ->rules(array(
    'subject_category_code' => 'required',
))
}}

@if (isset($subjectcategory))
    {{ Former::populate($subjectcategory->toArray()) }}
@endif

<div class="row">
    <div class="col-md-6">
        {{ Former::text('subject_category_code', lang('subjectcategory/attributes.labels.subject_category_code') . ' <span class="required">*</span> ' )
            ->placeholder(lang('subjectcategory/attributes.placeholders.subject_category_code')) }}

        {{ Former::text('subject_category_name', lang('subjectcategory/attributes.labels.subject_category_name') . ' <span class="required">*</span> ' )
            ->placeholder(lang('subjectcategory/attributes.placeholders.subject_category_name')) }}
    </div>
</div>

<br />
<div class="row">
    <div class="col-md-6">
        <div class="buttons">
            {{ create_save_button() }}
            {{ create_cancel_button(admin_url('/subjects/categories'),lang('texts.cancel_button')) }}
        </div>
    </div>
</div>

<input type="hidden" name="_success_url" value="{{ $success_url }}"/>
<input type="hidden" name="_return_url" value="{{ $return_url }}"/>
{{ Former::close() }}

@stop
