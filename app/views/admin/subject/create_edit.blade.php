@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ $page_title }}
    {{ create_back_button(admin_url('/subjects')) }}

    @if (isset($subject))
    <div class="pull-right">
        {{ $subject->present()->viewButton() }}
        {{ $subject->present()->exportButton() }}
        {{ $subject->present()->deleteButton() }}
    </div>
    @endif
</h1>
@overwrite

@section('main-content')

@include('admin._partials._messages')

{{ Former::vertical_open($url)->method($method)
    ->addClass('col-sm-10 form-check-ays parsley-form')
->setAttribute('autocomplete','off')
->setAttribute('id','subjects_update_form')
->rules(array(
    'subject_id' => 'required',
    'subject_capacity' => 'required|integer',
))
}}

@if (isset($subject))
{{ Former::populate($subject->toArray()) }}
@endif

<div class="row">
    <div class="col-md-6">
        {{ Former::text('subject_id', lang('subject/attributes.labels.subject_id') . ' <span class="required">*</span> ' )
            ->placeholder(lang('subject/attributes.placeholders.subject_id')) }}

        {{ Former::textarea('description', lang('subject/attributes.labels.description') . ' <span class="required">*</span> ')
            ->placeholder(lang('subject/attributes.placeholders.description')) }}

        {{ Former::text('subject_capacity', lang('subject/attributes.labels.subject_capacity') . ' <span class="required">*</span> ')
            ->placeholder(lang('subject/attributes.placeholders.subject_capacity')) }}
    </div>

</div>

<br />
<div class="row">
    <div class="col-md-6">
        <div class="buttons">
            {{ create_save_button() }}
            {{ create_cancel_button(admin_url('/subjects'),lang('texts.cancel_button')) }}
        </div>
    </div>
</div>

<input type="hidden" name="_success_url" value="{{ $success_url }}"/>
<input type="hidden" name="_return_url" value="{{ $return_url }}"/>
{{ Former::close() }}

@stop