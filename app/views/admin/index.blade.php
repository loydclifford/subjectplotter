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
                <li class="pull-left header"><i class="fa fa-inbox"></i> My Account </li>
            </ul>
            <div class="tab-content no-padding">
                <!-- big buttons holder-->
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; display: inline;">
                    <ul class="nav" style="position: relative; border: solid 2px #696969; height: 100px; width: 150px; padding: 10px;">
                        <i class="fa fa-book fa-3x" style="position: relative; border: solid 1px transparent;"></i>
                        <li class="header" style="position: relative; float: right; top: 12px;"> Total Courses </li>
                    </ul>
                </div>
            </div>
        </div><!-- /.nav-tabs-custom -->
    </section><!-- /.Left col -->

</div><!-- /.row (main row) -->

@stop

@section('after-footer')
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
@stop
