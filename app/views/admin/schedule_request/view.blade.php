
@extends('admin._partials._layout')

@section('main-content-header')
    <h1>
        {{ $student->user->first_name }} {{ $student->user->last_name }}
        <small>{{ $course_code }}-{{ $course_year_code }} ({{ $semester }})</small>
        -
        <small>{{ $student_plotting->status }}</small>

        <div class="pull-right">
            @if ($student_plotting->status != StudentPlotting::STATUS_APPROVED)
                <a class="confirm_action btn btn-success" data-message="Are you sure you want to approve this plotting?" href="{{ url("/admin/schedule-requests/{$student_plotting->id}/approved") }}">
                    Approve Plotting
                </a>
                <a class="confirm_action btn btn-warning" data-message="Are you sure you want to deny plotting?" href="{{ url("/admin/schedule-requests/{$student_plotting->id}/deny") }}">
                    Deny
                </a>
            @endif
        </div>
    </h1>

@overwrite

@section('main-content')
            @include('admin._partials._messages')
            <table class="table table-striped table-bordered" id="course_subject_schedule_lists">
                <thead>
                <tr>
                    <th>Subject</th>
                    <th>Descriptive Title</th>
                    <th>Units</th>
                    <th>DAY</th>
                    <th>Time Schedule</th>
                    <th>Room</th>
                    <th>Instructor</th>
                </tr>
                </thead>
                <tbody>
                <?php $total_units = 0; ?>
                @foreach ($course_subject_schedules as $course_subject_schedule)
                    <tr>
                        <?php $total_units = $total_units + (int) $course_subject_schedule->courseSubject->subject->units ?>
                        <td>{{ $course_subject_schedule->courseSubject->subject->subject_name }}</td>
                        <td>{{ $course_subject_schedule->courseSubject->subject->description }}</td>
                        <td>{{ $course_subject_schedule->courseSubject->subject->units }}</td>
                        <td>{{ $course_subject_schedule->present()->getDayString() }}</td>
                        <td>{{ $course_subject_schedule->present()->getTimeSchedule() }}</td>
                        <td>{{ $course_subject_schedule->room_id }}</td>
                        <td>{{ $course_subject_schedule->instructor->user->first_name }} {{ $course_subject_schedule->instructor->user->last_name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
@stop