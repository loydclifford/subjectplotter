@extends('public._partials._layout')

@section('main-content')
<div class="row-fluid">
    <div class="span12">
        <h4><i class="icon-user"></i>&nbsp;&nbsp; Subject Plotting - {{ get_current_school_year() }} - First Semester ({{ user_get()->student->course_code }} - {{ user_get()->student->course_year_code }})</h4>
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
                <th style="width:20px;" align="center">Status</th>
                <th style="width:20px;" align="center">Remove</th>
            </tr>
            </thead>
            <tbody>
                <?php $total_units = 0; ?>
                @foreach ($course_subjects as $course_subject)
                    <?php $total_units = $total_units + (int) $course_subject->subject->units ?>
                    <tr>
                        <td>{{ $course_subject->subject->subject_name }}</td>
                        <td>{{ $course_subject->subject->description }}</td>
                        <td>{{ $course_subject->subject->units }}</td>
                            @foreach (CourseSubjectSchedule::getDataPresetByCourseSubjectId($course_subject->id) as $course_subject_schedule)
                            <td>{{ $course_subject_schedule->present()->getDayString() }}</td>
                            <td>{{ $course_subject_schedule->present()->getTimeSchedule() }}</td>
                            <td>{{ $course_subject_schedule->room_id }}</td>
                            <td>{{ $course_subject_schedule->user_first_name }} {{ $course_subject_schedule->user_last_name }}</td>
                            <td align="center">
                                @if (Student::checkSchedule($course_subject->id))
                                <i class="fa fa-check-circle alert-success"></i>
                                @else
                                <i class="fa fa-check-circle alert-error"></i>
                                @endif
                            </td>
                            <td align="center"><a class="confirm_action" href="#" data-message="Are you sure you want to remove this subject to your schedule?"><i class="fa fa-remove"></i></a></td>
                            <?php break; ?>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        <br />

        <div class="pull-left">
            <a href="#add_subject_modal" class="btn btn-default" data-toggle="modal" >Add Subjects</a> &nbsp;
            <strong>Total Units: {{ $total_units }}</strong>
        </div>

        <div class="pull-right">
            <a href="{{ url('/plotting/load-defaults') }}" class="btn btn-default confirm_action" data-message="Are you sure you want to load default plotting?" >Load Defaults </a>
            <a href="{{ url('/plotting/load-defaults') }}" class="btn btn-success">Plot Schedule <i class="fa fa-check-square"></i></a>
        </div>
    </div>

</div>
<script>
    $(function() {
        console.log($('#course_subject_schedule_lists'));
        $('#course_subject_schedule_lists').DataTable(
                {
                    "order": [[ 2, "asc" ]],
                    "paging":   false,
                    "aoColumnDefs": [
                        { 'bSortable': false, 'aTargets': [ 5, 6 ] }
                    ]
                }
        );
    });
</script>

@stop

@section('after-footer')
{{-- Add Subject Modal --}}
<div class="modal fade" id="add_subject_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Former::vertical_open(admin_url('/subject-schedules/set-schedules/add-subject'))->method('POST')
                ->addClass('form-check-ays parsley-form form-inline')
                ->rules(array('school_year'=>'required', 'course_code'=>'required')) }}

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Subject</h4>
            </div>
            <div class="modal-body">
                <select name="subject_code" id="subject_code" class="form-control select2-select">
                    @foreach (Subject::all()->lists('subject_name', 'subject_code') as $key=>$value)
                        <option value="{{ $key }}" {{ is_disabled(in_array($key, $course_subjects->lists('subject_code'))) }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submiot" class="btn btn-primary">Add Subject</button>
            </div>

            <input type="hidden" name="course_code" value="{{ $course_subject->id }}" />
            {{ Former::close() }}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop