@extends('admin._partials._layout')

@section('main-content')

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
                <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
                <li class="pull-left header"><i class="fa fa-inbox"></i> Sales</li>
            </ul>
            <div class="tab-content no-padding">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 320px;"></div>
            </div>
        </div><!-- /.nav-tabs-custom -->
    </section><!-- /.Left col -->

</div><!-- /.row (main row) -->

@stop

@section('after-footer')
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
@stop