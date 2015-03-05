@extends('public._partials._layout')

@section('main-content')
<div class="row-fluid">
    <div class="span12">
        <h4><i class="icon-user"></i>&nbsp;&nbsp; Subject Plotting - {{ get_current_school_year() }} - First Semester ({{ user_get()->student->course_code }} - {{ user_get()->student->course_year_code }})</h4>
        <br />

        @if ($has_plotted)
            <p class="alert alert-info">You already plotted for this semester. status: {{ $has_plotted->status }}</p>
        @endif
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
                @if (!$has_plotted || ($has_plotted && $has_plotted->status == StudentPlotting::STATUS_DENIED))
                <th style="width:20px;" align="center">Remove</th>
                @endif
            </tr>
            </thead>
            <tbody>
                <?php $total_units = 0; $subject_codes = array() ;?>
                    @foreach ($course_subject_schedules as $course_subject_schedule)
                    <tr>
                        <?php $subject_codes[] = $course_subject_schedule->courseSubject->subject_code; ?>
                        <?php $total_units = $total_units + (int) $course_subject_schedule->courseSubject->subject->units ?>
                        <td>{{ $course_subject_schedule->courseSubject->subject->subject_name }}</td>
                        <td>{{ $course_subject_schedule->courseSubject->subject->description }}</td>
                        <td>{{ $course_subject_schedule->courseSubject->subject->units }}</td>
                        <td>{{ $course_subject_schedule->present()->getDayString() }}</td>
                        <td>{{ $course_subject_schedule->present()->getTimeSchedule() }}</td>
                        <td>{{ $course_subject_schedule->room_id }}</td>
                        <td>{{ $course_subject_schedule->instructor->user->first_name }} {{ $course_subject_schedule->instructor->user->last_name }}</td>

                            @if (!$has_plotted || ($has_plotted && $has_plotted->status == StudentPlotting::STATUS_DENIED))
                        <td align="center"><a class="confirm_action" href="{{ url('/subject/getRemove?course_subject_schedule_id='.urlencode($course_subject_schedule->id)) }}" data-message="Are you sure you want to remove this subject to your schedule?"><i class="fa fa-remove"></i></a></td>
                            @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <br />

        <div class="pull-left">
            @if (!$has_plotted || ($has_plotted && $has_plotted->status == StudentPlotting::STATUS_DENIED))
            <a href="#add_subject_modal" class="btn btn-default" data-toggle="modal" >Add Subjects</a> &nbsp;
            @endif
            <strong>Total Units: {{ $total_units }}</strong>&nbsp;
            <strong>Total Available Units: {{ $total_available_units - $total_units }}</strong>
        </div>

        <div class="pull-right">
            @if (!$has_plotted || ($has_plotted && $has_plotted->status == StudentPlotting::STATUS_DENIED))
            <a href="{{ url('/subject/load-default') }}" class="btn btn-default confirm_action" data-message="Are you sure you want to load Recommended plotting?" >Load Recommended </a>
            <a class="btn btn-success " id="submit_plotting_form_triggerer" >Plot Schedule <i class="fa fa-check-square"></i></a>

            {{ Former::vertical_open(url('/subject/submit-plotting'))->method('POST')
                ->setAttribute('id', 'submit_plotting_form')}}

                <input type="hidden" name="student_no" value="{{ $student_no }}" />
                <input type="hidden" name="course_year_code" value="{{ $course_year_code }}" />
                <input type="hidden" name="course_code" value="{{ $course_code }}" />
                <input type="hidden" name="semester" value="{{ $semester }}" />
                <input type="hidden" name="school_year" value="{{ $school_year }}" />
            {{ Former::close() }}
            @endif
        </div>
    </div>

</div>
<script>
    $(function() {

        $('#submit_plotting_form_triggerer').click(function(e) {
            e.preventDefault();

            bootbox.confirm('Are you sure you want to submit this plotting?', function(result) {
                if (result === true)
                {
                    $('#submit_plotting_form').submit();
                }
            });
        });

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
            markup += '<h3>'+subject.name+' &nbsp; &nbsp; <small>'+subject.course_year+'</small></h3>';
            markup += '</div>';
            markup += '<div>';
            markup += '<ul style="margin:0;padding:0; background: transparent">';
            markup += '<li><strong>Descriptive Title:  </strong> '+subject.descriptive_title + '</li>';
            markup += '<li> <strong>DAY: </strong> '+subject.day + '</li>';
            markup += '<li> <strong>Time: </strong> '+subject.time + '</li>';
            markup += '<li> <strong>Room: </strong> '+subject.room + '</li>';
            markup += '<li> <strong>Units: </strong> '+subject.units + '</li>';
            markup += '<li> <strong>Instructor: </strong> '+subject.instructor_name + '</li>';
            markup += '</ul>';
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
            return '<strong>'+subject.name+'</strong> <small>'+subject.course_year+' ('+subject.day+' - '+subject.time+')</small>';
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
                            exclude_course_subject_schedules_id: '{{ join(',', $course_subject_schedules->lists('id')) }}',
                            exclude_subject_code: '{{ join(',', $subject_codes) }}',
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

            {{ Former::vertical_open(url('/subject/add-subject'))->method('POST')
                ->addClass('form-check-ays parsley-form form-inline')
                ->rules(array('school_year'=>'required', 'course_code'=>'required')) }}

            <div class="modal-body">
                {{ Former::text('course_subject_schedule_id', 'Subject' )
                    ->setAttribute('style','width: 100%')
                    ->setAttribute('id','js_search_subject') }}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submiot" class="btn btn-primary">Add Subject</button>
            </div>

            <input type="hidden" name="student_no" value="{{ $student_no }}" />
            <input type="hidden" name="course_year_code" value="{{ $course_year_code }}" />
            <input type="hidden" name="course_code" value="{{ $course_code }}" />
            <input type="hidden" name="semester" value="{{ $semester }}" />
            <input type="hidden" name="school_year" value="{{ $school_year }}" />
            {{ Former::close() }}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop