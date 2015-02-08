@extends('admin._partials._layout')

@section('main-content-header')
    <h1>
        Set Schedules - {{ $course->course_code }} ({{ $school_year }})
    </h1>
@overwrite

@section('main-content')

    @include('admin._partials._messages')

    <div class="row">
        <div class="col-sm-12">
        {{ Former::vertical_open('#')->method('GET')
            ->addClass('form-check-ays parsley-form form-inline')
            ->rules(array('school_year'=>'required', 'course_code'=>'required'))}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="course_year_code" id="school_year" class="form-control">
                                @foreach ($course->courseYear as $course_year)
                                    <option value="{{ $course_year->course_year_code }}" {{ is_selected($course_year->course_year_code, $course_year_code) }}>{{ $course_year->course_code }} - {{ $course_year->course_year_code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="semester" id="course_code" class="form-control">
                                @foreach (get_semesters() as $key=>$value)
                                    <option value="{{ $key }}" {{ is_selected($key, $semester) }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-6">
                        <div class="buttons">
                            <button type="submit"class="btn btn-info">Select</button>
                            <a class="btn btn-default" href="{{ admin_url('/subject-schedules') }}">Back</a>
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
    @if (!empty($course) && !empty($school_year) && !empty($semester) && !empty($course_year_code))
        @include('admin.subjectschedule.setschedules.main')
    @endif
@stop

