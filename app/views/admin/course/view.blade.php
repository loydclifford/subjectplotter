@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ $course->course_code }}
        - {{ $course->present()->getShortDescription() }}

    {{ create_back_button(admin_url('/courses')) }}

    @if (isset($course))
        <div class="pull-right">
            {{ $course->present()->editButton() }}
            {{ $course->present()->exportButton() }}
            {{ $course->present()->deleteButton() }}
        </div>
    @endif
</h1>

@overwrite

@section('main-content')

@include('admin._partials._messages')
<p class="alert alert-info"><i class="fa fa-info"></i> Update course level by ordering below items.</p>
<div class="row">
    <div class="col-sm-7">
        <div id="dd-nestable" class="dd">
            <ol class="dd-list">
                @foreach ($course->courseYear as $course_year)
                    <li data-id="{{ $course_year->id  }}" class="dd-item dd3-item">
                        <div class="dd-handle dd3-handle"></div>
                        <div class="dd3-content">{{{ $course_year->course_year_code }}}
                            <span class="pull-right">
                                <a href="{{ admin_url("/courses/{$course->course_code}/view/?course_year_code={$course_year->course_year_code}") }}"><i class="fa fa-cogs"></i></a>
                            </span>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
        <br />

        {{ Former::vertical_open(admin_url("/course-years/reorder"))->method('POST')
            ->setAttribute('autocomplete','off')
            ->setAttribute('id','course_years_reorder')
            ->rules(array(
                'feature_name' => 'required',
            )) }}

            <div class="clearfix">
                <div class="buttons ">
                    {{ create_save_button(lang('texts.update_reorder_button'),false,'right') }}
                </div>
            </div>

            <input type="hidden" name="reorder" id="input_reorder" value="" />
        {{ Former::close() }}

    </div>
    <div class="col-sm-5">
        {{ Former::vertical_open($form_url)->method('POST')
              ->addClass(' parsley-form')
              ->setAttribute('autocomplete','off')
              ->setAttribute('id','courses_year_level_update_form')
              ->rules(array(
                  'course_year_code' => 'required',
              ))
          }}

            @if ($is_update)
                <legend>{{ lang('courseyear/texts.update_course_year_legend') }}</legend>
            @else
                <legend>{{ lang('courseyear/texts.create_course_year_legend') }}</legend>
            @endif

            {{ Former::text('course_year_code', lang('course/attributes.labels.course_year_code') )
                ->placeholder(lang('course/attributes.placeholders.course_year_code')) }}

            {{-- if this is an edit --}}
            @if ($is_update)
                <div class="clearfix">
                    <div class="buttons ">
                        <button class="btn-primary btn-success btn" type="submit">
                            <i class="fa fa-save"></i>
                            {{ lang('texts.update_button') }}
                        </button>
                        <a class="btn-primary btn-warning btn confirm_action" href="{{ admin_url("/course-years/delete?course_year_id={$course_year->id}") }}" data-message="{{{ lang('courseyear/texts.delete_confirmation')  }}}">
                            <i class="fa fa-times"></i>
                            {{ lang('texts.delete_action') }}
                        </a>
                        <a class="btn-primary btn-info btn" href="{{ admin_url($base_course_year_uri) }}">
                            <i class="fa fa-times"></i>
                            {{ lang('texts.add_new_button') }}
                        </a>
                    </div>
                </div>
            @else
                {{-- if an not an update --}}
                <button type="submit" class="btn btn-default" >Add Course Level</button>
            @endif

            {{-- if this is an edit --}}
            @if ($is_update)
                <input type="hidden" name="course_year_code_old" value="{{ $course_year->course_year_code }}"/>
                <input type="hidden" name="is_update" value="yes"/>
            @endif
            <input type="hidden" name="course_code" value="{{ $course->course_code }}"/>
        {{ Former::close() }}
    </div>
</div>

<script>
    $(function() {
        var $reorderForm = $('#course_years_reorder'),
                $reorder = $reorderForm.find('#input_reorder'),
                $nestable = $('#dd-nestable');

        // Register nestable
        var $dd = $('.dd');
        $dd.nestable({ maxDepth: 1 });
        // $dd.nestable('collapseAll');
        // $dd.nestable('expandAll');

        $reorderForm.submit(function(e) {
            var $this = $(this);

            var decodedObject = JSON.stringify($nestable.nestable('serialize'));
            $reorder.val(decodedObject);

            $.ajax({
                type: $this.attr('method'),
                url: $(this).attr('action'),
                data: $this.serialize(),
                dataType: 'JSON',
                success: function (data) {
                    // Process redirect
                    if (utils.result.RESULT_SUCCESS == data.status)
                    {
                        bootbox.alert("{{{ lang('courseyear/texts.success_fully_reordered') }}}");
                    }
                }
            });

            e.preventDefault();
        });


        //-- Add Course
        $('#courses_year_level_update_form').submit(function(e) {
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
    });
</script>
@stop