@extends('admin._partials._layout')

@section('main-content-header')
    <h1>
        {{ $page_title }}
    </h1>
@overwrite

@section('main-content')
<!-- Single button -->
    @include('admin.setting._tabs')

    {{ Former::vertical_open(admin_url('/settings/update'))->method('POST')
        ->addClass('form-check-ays parsley-form form-inline')
        ->setAttribute('autocomplete','off')
        ->setAttribute('id','semester_setting_update_form') }}
        <legend>First Semester</legend>
        <div class="row">
            <div class="col-sm-6">
                <label class="" for="exampleInputEmail3">Enrollment Start Date: &nbsp;</label>
                <div class="form-group">
                    <select name="setting[first_semester_enrollment_start_date_m]" class="form-control">
                        <option disabled value=""> - M - </option>
                        @foreach (getMonths() as $key=>$value)
                        <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('first_semester_enrollment_start_date_m')) }}>{{ $key . '-' .$value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select name="setting[first_semester_enrollment_start_date_d]" class="form-control">
                        <option disabled value=""> - D - </option>
                        @foreach (getDays() as $key=>$value)
                            <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('first_semester_enrollment_start_date_m')) }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label class="" for="exampleInputEmail3">Enrollment End Date: &nbsp;</label>
                <div class="form-group">
                    <select name="setting[first_semester_enrollment_end_date_m]" class="form-control">
                        <option disabled value=""> - M - </option>
                        @foreach (getMonths() as $key=>$value)
                        <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('first_semester_enrollment_end_date_m')) }}>{{ $key . '-' .$value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select name="setting[first_semester_enrollment_end_date_d]" class="form-control">
                        <option disabled value=""> - D - </option>
                        @foreach (getDays() as $key=>$value)
                            <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('first_semester_enrollment_end_date_d')) }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label class="" for="exampleInputEmail3">Enrollment Start Date: &nbsp;</label>
                <div class="form-group">
                    <select name="setting[first_semester_semester__start_date_m]" class="form-control">
                        <option disabled value=""> - M - </option>
                        @foreach (getMonths() as $key=>$value)
                            <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('first_semester_semester__start_date_m')) }}>{{ $key . '-' .$value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select name="setting[first_semester_semester__start_date_d]" class="form-control">
                        <option disabled value=""> - D - </option>
                        @foreach (getDays() as $key=>$value)
                            <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('first_semester_semester__start_date_m')) }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label class="" for="exampleInputEmail3">Semester Start Date: &nbsp;</label>
                <div class="form-group">
                    <select name="setting[first_semester_semester__end_date_m]" class="form-control">
                        <option disabled value=""> - M - </option>
                        @foreach (getMonths() as $key=>$value)
                            <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('first_semester_semester__end_date_m')) }}>{{ $key . '-' .$value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select name="setting[first_semester_semester__end_date_d]" class="form-control">
                        <option disabled value=""> - D - </option>
                        @foreach (getDays() as $key=>$value)
                            <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('first_semester_semester__end_date_d')) }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <br />
    <legend>Second Semester</legend>
    <div class="row">
        <div class="col-sm-6">
            <label class="" for="exampleInputEmail3">Enrollment Start Date: &nbsp;</label>
            <div class="form-group">
                <select name="setting[second_semester_enrollment_start_date_m]" class="form-control">
                    <option disabled value=""> - M - </option>
                    @foreach (getMonths() as $key=>$value)
                        <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_enrollment_start_date_m')) }}>{{ $key . '-' .$value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="setting[second_semester_enrollment_start_date_d]" class="form-control">
                    <option disabled value=""> - D - </option>
                    @foreach (getDays() as $key=>$value)
                        <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_enrollment_start_date_m')) }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="" for="exampleInputEmail3">Enrollment End Date: &nbsp;</label>
            <div class="form-group">
                <select name="setting[second_semester_enrollment_end_date_m]" class="form-control">
                    <option disabled value=""> - M - </option>
                    @foreach (getMonths() as $key=>$value)
                        <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_enrollment_end_date_m')) }}>{{ $key . '-' .$value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="setting[second_semester_enrollment_end_date_d]" class="form-control">
                    <option disabled value=""> - D - </option>
                    @foreach (getDays() as $key=>$value)
                        <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_enrollment_end_date_d')) }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <label class="" for="exampleInputEmail3">Enrollment Start Date: &nbsp;</label>
            <div class="form-group">
                <select name="setting[second_semester_semester__start_date_m]" class="form-control">
                    <option disabled value=""> - M - </option>
                    @foreach (getMonths() as $key=>$value)
                        <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_semester__start_date_m')) }}>{{ $key . '-' .$value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="setting[second_semester_semester__start_date_d]" class="form-control">
                    <option disabled value=""> - D - </option>
                    @foreach (getDays() as $key=>$value)
                        <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_semester__start_date_m')) }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="" for="exampleInputEmail3">Semester Start Date: &nbsp;</label>
            <div class="form-group">
                <select name="setting[second_semester_semester__end_date_m]" class="form-control">
                    <option disabled value=""> - M - </option>
                    @foreach (getMonths() as $key=>$value)
                        <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_semester__end_date_m')) }}>{{ $key . '-' .$value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="setting[second_semester_semester__end_date_d]" class="form-control">
                    <option disabled value=""> - D - </option>
                    @foreach (getDays() as $key=>$value)
                        <option value="{{ $key }}" {{ is_selected($key, Setting::getSetting('second_semester_semester__end_date_d')) }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="buttons">
                    {{ create_save_button() }}
                </div>
            </div>
        </div>

    {{ Former::close() }}
@stop

@section('after-footer')
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
@stop
