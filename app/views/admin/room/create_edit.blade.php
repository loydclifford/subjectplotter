@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ $page_title }}
    {{ create_back_button(admin_url('/rooms')) }}

    @if (isset($room))
    <div class="pull-right">
        {{ $room->present()->viewButton() }}
        {{ $room->present()->exportButton() }}
        {{ $room->present()->deleteButton() }}
    </div>
    @endif
</h1>
@overwrite

@section('main-content')

@include('admin._partials._messages')

{{ Former::vertical_open($url)->method($method)
    ->addClass('col-sm-10 form-check-ays parsley-form')
->setAttribute('autocomplete','off')
->setAttribute('id','rooms_update_form')
->rules(array(
    'room_id' => 'required',
    'room_capacity' => 'required|integer',
))
}}

@if (isset($room))
{{ Former::populate($room->toArray()) }}
@endif

<div class="row">
    <div class="col-md-6">
        {{ Former::text('room_id', lang('room/attributes.labels.room_id') . ' <span class="required">*</span> ' )
            ->placeholder(lang('room/attributes.placeholders.room_id')) }}

        {{ Former::textarea('description', lang('room/attributes.labels.description') . ' <span class="required">*</span> ')
            ->placeholder(lang('room/attributes.placeholders.description')) }}

        {{ Former::text('room_capacity', lang('room/attributes.labels.room_capacity') . ' <span class="required">*</span> ')
            ->placeholder(lang('room/attributes.placeholders.room_capacity')) }}
    </div>

</div>

<br />
<div class="row">
    <div class="col-md-6">
        <div class="buttons">
            {{ create_save_button() }}
            {{ create_cancel_button(admin_url('/rooms'),lang('texts.cancel_button')) }}
        </div>
    </div>
</div>

<input type="hidden" name="_success_url" value="{{ $success_url }}"/>
<input type="hidden" name="_return_url" value="{{ $return_url }}"/>
{{ Former::close() }}

@stop