@extends('admin._partials._layout')

@section('main-content-header')
    <h1>
        {{ $student->user->first_name }} {{ $student->user->last_name }}
        <small>{{ $course_code }}-{{ $course_year_code }} ({{ $semester }})</small>
        -
        <small>{{ $student_plotting->status }}</small>
    </h1>

@overwrite

@section('main-content')

    {{ Former::vertical_open(URL::current())->method('POST')
        ->setAttribute('autocomplete','off')
        ->setAttribute('id','grade_entry_form') }}
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
                <th>Final</th>
            </tr>
            </thead>
            <tbody>
            <?php $total_units = 0; ?>
            @foreach ($student_subjects as $student_subject)
                <?php $course_subject_schedule = $student_subject->courseSubjectSchedule;
                ?>
                <tr>
                    <?php $total_units = $total_units + (int) $course_subject_schedule->courseSubject->subject->units ?>
                    <td>{{ $course_subject_schedule->courseSubject->subject->subject_name }}</td>
                <td>{{ $course_subject_schedule->courseSubject->subject->description }}</td>
                <td>{{ $course_subject_schedule->courseSubject->subject->units }}</td>
                <td>{{ $course_subject_schedule->present()->getDayString() }}</td>
                <td>{{ $course_subject_schedule->present()->getTimeSchedule() }}</td>
                <td>{{ $course_subject_schedule->room_id }}</td>
                <td>{{ $course_subject_schedule->instructor->user->first_name }} {{ $course_subject_schedule->instructor->user->last_name }}</td>
            <td>

                    <select name="average[{{ $student_subject->id }}]">
                        <option value="">-- Grade --</option>
                        @for ($i=1.0;$i<=5.0;$i+=.1)
                            <option {{ (trim($i) == trim($student_subject->average)) ? 'selected="selected"' : NULL }} value="{{ number_format($i, 1) }}">{{ number_format($i, 1) }}</option>
                        @endfor
                        <option {{ is_selected(0, $student_subject->average) }} value="0">0</option>
                        <option {{ is_selected('NA', $student_subject->average) }} value="NA">NA</option>
                        <option {{ is_selected('INC', $student_subject->average) }} value="INC">INC</option>
                    </select>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        <button type="submit" class="btn btn-primary">Submit Grade</button>
    </div>
    {{ Former::close() }}
@stop