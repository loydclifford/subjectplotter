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
<div id="dd-nestable" class="dd">
    <ol class="dd-list">
        @foreach ($course->courseYear() as $course_year)
            <li data-id="{{ $course_year->course_year_code  }}" class="dd-item dd3-item">
                <div class="dd-handle dd3-handle"></div>
                <div class="dd3-content">{{{ $course_year->course_year_code }}}
                    <span class="pull-right">
                        <a href="{{ admin_url("/courses/{$course->course_code}/view/?course_code_year={$course_year->course_year_code}") }}"><i class="fa fa-cogs"></i></a>
                    </span>
                </div>
            </li>
        @endforeach
    </ol>
</div>

<script>
    $(function() {
        var $reorderForm = $('#features_reorder'),
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

            utils.sendAjax($reorder, $this.attr('action'), $this.attr('method'), $this.serialize(), 'JSON',
                    function (data,status_code,xhr) {
                        if (data.status == utils.result.RESULT_SUCCESS) {
                            $nestable.removeClass('updating-item');
                            bootbox.alert("{{{ lang('feature::texts.success_fully_reordered') }}}");
                        }
                    },
                    function() {
                        $nestable.addClass('updating-item');
                    }
            );

            e.preventDefault();
        });

    });
</script>
@stop