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
    'subject_code' => 'required',
))
}}
@if (isset($subject))
{{ Former::populate($subject->toArray()) }}
@endif

<div class="row">
    <div class="col-md-6">
        {{ Former::text('subject_code', lang('subject/attributes.labels.subject_code') . ' <span class="required">*</span> ' )
            ->placeholder(lang('subject/attributes.placeholders.subject_code')) }}

        {{ Former::text('subject_name', lang('subject/attributes.labels.subject_name') . ' <span class="required">*</span> ' )
            ->placeholder(lang('subject/attributes.placeholders.subject_name')) }}

        {{ Former::select('units', lang('subject/attributes.labels.units') . ' <span class="required">*</span> ' )
            ->placeholder(lang('subject/attributes.placeholders.units'))
            ->options(Subject::$units) }}

        {{ Former::textarea('description', lang('subject/attributes.labels.description') . ' <span class="required">*</span> ')
            ->placeholder(lang('subject/attributes.placeholders.description')) }}

        @if (isset($subject) && $subject->subjectPrequisites)
            <div class="form-group">
                <label for="prerequisite" class="control-label">
                    Prerequisite(s) <span class="required">*</span>
                </label>
                <select class="form-control select2-select" multiple="true" id="prerequisite" name="prerequisite[]">
                    <option value="" disabled>{{ lang('subject/attributes.placeholders.prerequisite') }}</option>
                    @foreach((Subject::getSubjects(isset($subject) ? array($subject->subject_code) : array())) as $key=>$value)
                    <option value="{{ $key }}" {{ in_array($key, ($subject->subjectPrequisites ? $subject->subjectPrequisites->lists('prerequisite_subject_code') : array())) ? "selected=\"selected\"" : NULL }}> {{ $value }}</option>
                    @endforeach
                </select>
            </div>
        @else
        {{ Former::multiselect('prerequisite', lang('subject/attributes.labels.prerequisite') . ' <span class="required">*</span> ' )
            ->placeholder(lang('subject/attributes.placeholders.prerequisite'))
            ->multiple()
            ->addClass('select2-select')
            ->options(Subject::getSubjects(isset($subject) ? array($subject->subject_code) : array())) }}
        @endif

        {{ Former::select('subject_category_code', lang('subject/attributes.labels.subject_category_code') . ' <span class="required">*</span> ' )
            ->placeholder(lang('subject/attributes.placeholders.subject_category_code'))
             ->options(SubjectCategory::all()->lists('subject_category_name', 'subject_category_code')) }}
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
