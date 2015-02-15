@extends('public._partials._layout')

@section('main-content')
<div class="row-fluid">
    <div class="span12">
        <h4><i class="icon-user"></i>&nbsp;&nbsp; Subject Plotting - 2014-2015 - First Semester</h4>
        <table class="table table-striped table-bordered" id="course_subject_schedule_lists">
            <tr>
                <th>DAY</th>
                <th>Time Schedule</th>
                <th>Room</th>
                <th>Capacity</th>
                <th>Instructor</th>
                <th style="width:20px;">&nbsp;</th>
                <th style="width:20px;">&nbsp;</th>
            </tr>

                <tr>
                    <td>{ $course_subject_schedule->present()->getDayString() }}</td>
                    <td>{ $course_subject_schedule->present()->getTimeSchedule() }}</td>
                    <td>{ $course_subject_schedule->room_id }}</td>
                    <td>{ $course_subject_schedule->room_capacity }}</td>
                    <td><a href="{ admin_url("/instructors/{$course_subject_schedule->instructor_id}/edit") }}" target="_blank">{ $course_subject_schedule->user_first_name }} { $course_subject_schedule->user_last_name }} </a></td>
                    <td><a class="action_edit" href="{ admin_url('/subject-schedules/set-schedules/get-form-edit-schedule?course_subject_schedule_id='.urlencode($course_subject_schedule->id)) }}"><i class="fa fa-edit"></i></a></td>
                    <td><a class="confirm_action" href="{ admin_url('/subject-schedules/set-schedules/remove-schedule?course_subject_schedule_id='.urlencode($course_subject_schedule->id)) }}" data-message="Are you sure you want to remove this schedule from this subject?"><i class="fa fa-remove"></i></a></td>
                </tr>
        </table>
   </div>

</div>

@stop