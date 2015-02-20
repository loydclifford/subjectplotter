
@extends('admin._partials._layout')

@section('main-content-header')
    <h1>
        {{ $student->user->first_name }} {{ $student->user->last_name }}
        <small>{{ $student->course_code }}-{{ $student->course_year_code }}</small>
        {{ create_back_button(admin_url('/students')) }}
    </h1>

@overwrite

@section('main-content')
    @include('admin._partials._messages')

    <p class="alert alert-info">No subject schedules yet.</p>
@stop