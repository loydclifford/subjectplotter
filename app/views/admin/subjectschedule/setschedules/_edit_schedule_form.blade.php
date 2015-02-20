
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Update Subject Schedule</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <label  class="control-label">Schedule Days: </label>
        <div>
            @foreach(get_schedule_days() as $key=>$value)
                <label class="checkbox-inline">
                    <input type="checkbox"  name="days[]" {{ is_checked($course_subject_schedule->{$key}, 1) }} data-parsley-mincheck="1" required value="{{ $key }}"> {{ $value }}
                </label>
            @endforeach
        </div>
    </div>

    {{ Former::select('room_id', 'Room')
        ->options(Room::all()->lists('room_id', 'room_id'))
        ->forceValue($course_subject_schedule->room_id) }}

    {{ Former::select('instructor_id', 'Instructor')
        ->options(Instructor::getInstructorBySubjectCategory($course_subject->subject->subject_category_code)->lists('full_name', 'instructor_id'))
        ->forceValue($course_subject_schedule->instructor_id) }}

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label  for="exampleInputAmount">Start Time</label>
                <div class="input-group  bootstrap-timepicker">
                    <input name="time_start" type="text" class="form-control timepicker1" value="{{ date('h:i A', strtotime($course_subject_schedule->time_start)) }}" required >
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
                    <input name="time_end" type="text" class="form-control timepicker1" value="{{ date('h:i A', strtotime($course_subject_schedule->time_end)) }}" required>
                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submiot" class="btn btn-primary">Update Subject</button>
</div>

<input type="hidden" name="course_subject_id" value="{{ $course_subject->id }}" />
<input type="hidden" name="course_subject_schedule_id" value="{{ $course_subject_schedule->id }}" />

<script>
    $(function() {
        $('.timepicker1').timepicker({
            defaultTime: '07:00 AM',
            minuteStep: 30,
            showSeconds: false,
            showMeridian: true,
            template: 'dropdown'
        });
    });
</script>
