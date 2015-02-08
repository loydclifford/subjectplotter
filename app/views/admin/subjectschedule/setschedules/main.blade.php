<div class="row">
    <div class="col-sm-3">
        <table class="table table-striped table-bordered">
            <tr>
                <th>Course Subjects</th>
                <th style="width:20px;">&nbsp;</th>
            </tr>
            @foreach ($course_subjects as $course_subject)
            <tr>
                <td>
                    @if ($selected_course_subject && $course_subject->subject_code == $selected_course_subject->subject_code)
                        <strong>{{ $course_subject->subject->subject_name }}</strong>
                    @else
                        <a href="{{ admin_url('/subject-schedules/set-schedules?course_subject_id='.urlencode($course_subject->id)) }}">{{ $course_subject->subject->subject_name }}</a>
                    @endif
                </td>
                <td><a class="confirm_action" data-message="Are you sure you want to remove this subject from this course?" href="{{ admin_url('/subject-schedules/set-schedules/remove-subject?course_subject_id='.urlencode($course_subject->id)) }}"><i class="fa fa-remove"></i></a></td>
            </tr>
            @endforeach
        </table>
        <a href="#" class="btn btn-default js-add-subject-modal-btn" data-toggle="modal" data-target="#modal-add-subject">Add Subject</a>
    </div>
    <div class="col-sm-9">
        @if ($selected_course_subject)
            <h3>{{ $selected_course_subject->subject->subject_name }} ({{ $selected_course_subject->subject_code }}) - Room Schedules</h3>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>DAY</th>
                    <th>Time Schedule</th>
                    <th>Room</th>
                    <th>Capacity</th>
                    <th>Instructor</th>
                    <th style="width:20px;">&nbsp;</th>
                    <th style="width:20px;">&nbsp;</th>
                </tr>

                @foreach (CourseSubjectSchedule::getDataPresetByCourseSubjectId($selected_course_subject->id) as $course_subject_schedule)
                    <tr>
                        <td>{{ $course_subject_schedule->present()->getDayString() }}</td>
                        <td>{{ $course_subject_schedule->present()->getTimeSchedule() }}</td>
                        <td>{{ $course_subject_schedule->room_id }}</td>
                        <td>{{ $course_subject_schedule->room_capacity }}</td>
                        <td><a href="{{ admin_url("/instructors/{$course_subject_schedule->instructor_id}/edit") }}" target="_blank">{{ $course_subject_schedule->user_first_name }} {{ $course_subject_schedule->user_last_name }} </a></td>
                        <td><a href="#"><i class="fa fa-edit"></i></a></td>
                        <td><a  class="confirm_action" href="{{ admin_url('/subject-schedules/set-schedules/remove-schedule?course_subject_schedule_id='.urlencode($course_subject_schedule->id)) }}" data-message="Are you sure you want to remove this schedule from this subject?"><i class="fa fa-remove"></i></a></td>
                    </tr>
                @endforeach
            </table>

            <a href="#" class="btn btn-default" data-toggle="modal" data-target="#modal-add-room-schedule">Add Room Schedule</a>
        @else
            <p>No selected subject.</p>
        @endif
    </div>
</div>



{{-- Add Subject Modal --}}
<div class="modal fade" id="modal-add-subject">
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
                    <select name="subject_code" id="subject_code" class="form-control">
                        @foreach (Subject::all()->lists('subject_name', 'subject_code') as $key=>$value)
                            <option value="{{ $key }}" {{ is_disabled(in_array($key, $course_subjects->lists('subject_code'))) }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submiot" class="btn btn-primary">Add Subject</button>
                </div>

                <input type="hidden" name="course_code" value="{{ $course->course_code }}" />
                <input type="hidden" name="school_year" value="{{ $school_year }}" />
                <input type="hidden" name="semester" value="{{ $semester }}" />
                <input type="hidden" name="course_year_code" value="{{ $course_year_code }}" />
            {{ Former::close() }}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


{{-- Add Room Schedule --}}
@if ($selected_course_subject)
<div class="modal fade" id="modal-add-room-schedule">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Former::vertical_open(admin_url('/subject-schedules/set-schedules/add-schedule'))->method('POST')
                ->addClass(' parsley-form ')
                ->rules(array('school_year'=>'required', 'room_id'=>'required', 'instructor_id'=>'required'))
                 ->setAttribute('id', 'add_schedule_form')}}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Subject</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label  class="control-label">Subject Schedule: </label>
                        <div>
                            @foreach(get_schedule_days() as $key=>$value)
                            <label class="checkbox-inline">
                                <input type="checkbox"  name="days[]" data-parsley-mincheck="1" required value="{{ $key }}"> {{ $value }}
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{ Former::select('room_id', 'Room')
                        ->options(Room::all()->lists('room_id', 'room_id')) }}

                    {{ Former::select('instructor_id', 'Instructor')
                        ->options(Instructor::getInstructorBySubjectCategory($selected_course_subject->subject->subject_category_code)->lists('full_name', 'instructor_id')) }}

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label  for="exampleInputAmount">Start Time</label>
                                <div class="input-group  bootstrap-timepicker">
                                    <input name="time_start" type="text" class="form-control timepicker1" required >
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label  for="exampleInputAmount">End Time</label>
                                <div class="input-group  bootstrap-timepicker">
                                    <input name="time_end" type="text" class="form-control timepicker1" required>
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submiot" class="btn btn-primary">Add Subject</button>
                </div>

                <input type="hidden" name="course_subject_id" value="{{ $selected_course_subject->id }}" />
            {{ Former::close() }}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


    <script>
        $(function() {
            $('#add_schedule_form').submit(function(e) {
                e.preventDefault();
                if ( $(this).parsley().isValid() ) {
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        dataType: 'JSON',
                        success: function (data) {
                            // Process redirect
                            if (utils.result.RESULT_SUCCESS == data.status)
                            {
                                utils.redirect(utils.currentUrl);
                            }
                            else
                            {
                                bootbox.alert(data.message);
                            }
                        }
                    });
                }
            });
        })
    </script>
@endif