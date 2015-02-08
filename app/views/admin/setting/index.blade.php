@extends('admin._partials._layout')

@section('main-content-header')
    <h1>
        {{ $page_title }}
    </h1>
@overwrite

@section('main-content')
<!-- Single button -->
    @include('admin.setting._tabs')
    {{ Former::vertical_open(admin_url('/settings/update'))->method('POST')
        ->addClass('col-sm-10 form-check-ays parsley-form')
        ->setAttribute('autocomplete','off')
        ->setAttribute('id','general_update_form') }}
        <div class="row">
            <div class="col-sm-6">
                {{ Former::text('setting[site_title_prefix]', 'Site Title Prefix' )
                    ->placeholder('Enter Site Title Prefix')
                    ->forceValue(Setting::getSetting('site_title_prefix')) }}

                {{ Former::text('setting[site_title_suffix]', 'Site Title Suffix' )
                    ->placeholder('Enter Site Title Suffix')
                    ->forceValue(Setting::getSetting('site_title_suffix')) }}

                {{ Former::text('setting[site_admin_email]', 'Admin Email' )
                    ->placeholder('Enter Admin Email')
                    ->forceValue(Setting::getSetting('site_admin_email')) }}
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-6">
                <div class="buttons">
                    {{ create_save_button() }}
                </div>
            </div>
        </div>

    {{ Former::close() }}
@stop

@section('after-footer')
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
@stop
