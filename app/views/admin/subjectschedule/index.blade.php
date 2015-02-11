@extends('admin._partials._layout')

@section('main-content-header')
    <h1>
        {{ lang('subjectschedule/texts.page_title') }}
        <a  class="btn btn-primary" href="{{ admin_url('/subjects/create') }}"><i class="fa fa-plus"></i> {{ lang('subjectschedule/texts.create') }}</a>
    </h1>
@overwrite

@section('main-content')
    <div class="row">
        <div class="col-sm-12">
        {{ Former::vertical_open('#')->method('POST')
            ->addClass('form-check-ays parsley-form form-inline')
            ->rules(array('school_year'=>'required', 'course_code'=>'required'))}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="school_year" id="school_year" class="form-control">
                                @foreach (school_years() as $key=>$value)
                                    <option value="{{ $key }}" {{ is_selected($key, Input::get('school_year')) }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="course_code" id="course_code" class="form-control">
                                <option disabled value="">{{ lang('subjectschedule/attributes.placeholders.course_code') }}</option>
                                @foreach (Course::all()->lists('course_code', 'course_code') as $key=>$value)
                                    <option value="{{ $key }}" {{ is_selected($key, Input::get('course_code')) }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-6">
                        <div class="buttons" style="position:absolute; top:-65px; left: 300px;">
                            <button type="submit"class="btn btn-primary">Proceed</button>
                        </div>
                    </div>
                </div>
            {{ Former::close() }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <hr />
        </div>
    </div>

@stop

