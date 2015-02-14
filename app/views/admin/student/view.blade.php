
@extends('admin._partials._layout')

@section('main-content-header')
<h1>
    {{ $student->present()->getDisplayName() }}
        - #{{ $student->student_code }}
    <small>
        {{ $student->student_type }}
    </small>

    {{ create_back_button(admin_url('/students')) }}

    @if (isset($student))
        <div class="pull-right">
            {{ $student->present()->editButton() }}
            {{ $student->present()->exportButton() }}
            {{ $student->present()->deleteButton() }}
        </div>
    @endif
</h1>

@overwrite

@section('main-content')

@include('admin._partials._messages')

    <div class="row">
        <div class="col-md-4">
            <h3>{{ trans('student::texts.details') }}</h3>
            <p>{{ $student->studentDetail->getAddress() }}</p>
            <p>{{ $student->studentDetail->getPhone() }}</p>
        </div>
        <div class="col-md-5">
            <h3>{{ trans('student::texts.contacts') }}</h3>
            {{ $student->present()->getContactDetails() }}
        </div>
    </div>

    <p>&nbsp;</p>

    <div class="row">
        <div class="col-sm-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab_vehicles">Vehicles</a></li>
                    <li class=""><a data-toggle="tab" href="#tab_orders">Orders</a></li>
                    <li class=""><a data-toggle="tab" href="#tab_enquiries">Enquiries</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab_vehicles" class="tab-pane active">
                        @include('admin.listing._tblist',array(
                        'list' => $listing_list,
                        'list_action' => $listing_list_action
                        ))
                    </div><!-- /.tab-pane -->
                    <div id="tab_orders" class="tab-pane">
                        @include('admin.order._tblist',array(
                        'list' => $order_list,
                        'list_action' => $order_list_action
                        ))
                    </div><!-- /.tab-pane -->
                    <div id="tab_enquiries" class="tab-pane">
                        @include('admin.listing_enquiry._tblist',array(
                            'list' => $listing_enquiry_list,
                            'list_action' => $listing_enquiry_action
                        ))
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div>
        </div>
    </div>
@stop