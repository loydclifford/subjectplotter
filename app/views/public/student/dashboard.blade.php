@extends('public._partials._layout')

@section('main-content')
<div class="row-fluid">
    <div class="span12">
        <div>
            <div class="row">

                <div class="col-xs-6">
                    <h3>MATH 1 <small>BSIT-I</small></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <ul class="nav">
                        <li><strong>Descriptive Title:  </strong> Descriptive Title</li>
                        <li><strong>DAY: </strong> Mon-Wed-Fri</li>
                        <li><strong>Time: </strong> 11:00 am - 12:00 pm</li>
                    </ul>
                </div>
                <div class="col-xs-6">
                    <ul class="nav">
                        <li><strong>Room: </strong> RM-02</li>
                        <li><strong>Units: </strong> 3</li>
                        <li><strong>Instructor: </strong> Skyla Romaguera</li>
                    </ul>
                </div>
            </div>
        </div>
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
                            <td>{{ $course_subject_schedule->instructor->first_name }} {{ $course_subject_schedule->instructor->last_name }}</td>
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
            <strong>Total Units: {{ $total_units }}</strong>&nbsp;
            <strong>Total Available Units: {{ $total_available_units }}</strong>
        </div>

        <div class="pull-right">
            <a href="{{ url('/plotting/load-defaults') }}" class="btn btn-default confirm_action" data-message="Are you sure you want to load default plotting?" >Load Defaults </a>
            <a href="{{ url('/plotting/load-defaults') }}" class="btn btn-success">Plot Schedule <i class="fa fa-check-square"></i></a>
        </div>
    </div>

</div>
<script>
    var searchSubject = function ($element) {
        this.$select = $element;
        this.endPoint = utils.baseUrl("/subject/search-select");
        this.placeholder = 'Search for a subject ..';

        /**
         * This would return an html for the select2 content
         *
         * @param user
         * @returns {string}
         */
        this.formatResult = function(subject){

            var markup = '';
            markup += '<table class="customer" width="500px"><tr><td class="customer-info">';
            markup += '<div>';
            markup += '<h3>'+subject.name+'<small>'+subject.course_year+'</small></h3>';
            markup += '</div>';
            markup += '<div>';
            markup += '<strong>Descriptive Title:  </strong> '+subject.descriptive_title;
            markup += ', <strong>DAY: </strong> '+subject.day;
            markup += ', <strong>Time: </strong> '+subject.time;
            markup += ', <strong>Room: </strong> '+subject.room;
            markup += ', <strong>Units: </strong> '+subject.units;
            markup += ', <strong>Instructor: </strong> '+subject.instructor_name;
            markup += '</div>';
            markup += '</div>';
            markup += "</td></tr></table>";

            return markup;
        };

        /**
         * When selected one of the result, we will generate the id and name of the user to be display
         * and put to hidden input box as the user for this discount
         *
         * @param user
         * @returns {string}
         */
        this.formatSelection = function(subject) {
            return subject.name+'<small>'+subject.course_year+'</small>';
        };

        /**
         * Run Selector
         *
         */
        this.init = function() {
            var _self = this;
            /**
             * This will search an user from the backend + user (PAP)
             *
             * @return null
             */
            _self.$select.select2({
                placeholder: _self.placeholder,
                minimumInputLength: 0,
                dropdownAutoWidth : true,
                allowClear: true,
                dropdownAutoWidth: true,
                ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                    url: _self.endPoint,
                    dataType: 'json',
                    data: function (term, page) {
                        var param = {
                            q: term, // search term
                            per_page: 25,
                            page: page,
                            _token: utils._token
                        };

                        // @note return format must be an json with a {total:20}{items:items_array
                        return param;
                    },

                    results: function (data, page) {
                        // parse the results into the format expected by Select2.
                        // since we are using custom formatting functions we do not need to alter remote JSON data
                        var more = (page * 25) < data.total;
                        return {results: data.subjects, more: more};
                    }
                },
                initSelection: function(element, callback) {
                    // the input tag has a value attribute preloaded that points to a preselected user's id
                    // this function resolves that id attribute to an object that select2 can render
                    // using its formatResult renderer - that way the movie name is shown preselected
                    var id = $(element).val();

                    if (id !== "")
                    {
                        $.ajax(_self.endPoint, {
                            data: {
                                id: id,
                                method: "init-selection",
                                _token: utils._token
                            },
                            dataType: "json"
                        }).done(function(data) {
                            callback(data);
                        });
                    }
                },
                formatResult: this.formatResult, // omitted for brevity, see the source of this page
                formatSelection: this.formatSelection,  // omitted for brevity, see the source of this page
                //dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
                escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
            });
        };
    };


    $(function() {
        var $searchSubject = new searchSubject($('#js_search_subject'));
        $searchSubject.init();

        $('#course_subject_schedule_lists').DataTable(
                {
                    "order": [[ 3, "asc" ], [ 4, "desc" ]],
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

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color:black;">Add Subject</h4>
            </div>

            {{ Former::vertical_open(admin_url('/subject-schedules/set-schedules/add-subject'))->method('POST')
                ->addClass('form-check-ays parsley-form form-inline')
                ->rules(array('school_year'=>'required', 'course_code'=>'required')) }}

            <div class="modal-body">
                {{ Former::text('subject_id', 'Subject' )
                    ->setAttribute('style','width: 100%')
                    ->setAttribute('id','js_search_subject') }}
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