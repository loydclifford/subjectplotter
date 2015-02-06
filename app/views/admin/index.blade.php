@extends('admin._partials._layout')

@section('main-content')
<div class="col-lg-6">
    <div class="input-group">
      <input type="text" class="form-control" aria-label="...">
      <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">
          <li><a href="#">Action</a></li>
          <li><a href="#">Another action</a></li>
          <li><a href="#">Something else here</a></li>
          <li class="divider"></li>
          <li><a href="#">Separated link</a></li>
        </ul>
      </div><!-- /btn-group -->
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
 
<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable meo_body">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="nav-tabs-custom romeo_head">
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
             
            <div class="tab-content" style="position: absolute; top: 27px; left: 245px; ">
                <!-- big buttons holder-->
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; display: inline;">
                    <ul class="nav" style="position: relative; border: solid 2px #696969; height: 100px; width: 150px; padding: 10px;">
                        <i class="fa fa-book fa-3x" style="position: relative; border: solid 1px transparent;"></i>
                        <li class="header" style="position: relative; float: right; top: -30px;"> Total Students </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content" style="position: absolute; top: 27px; left: 490px; ">
                <!-- big buttons holder-->
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; display: inline;">
                    <ul class="nav" style="position: relative; border: solid 2px #696969; height: 100px; width: 150px; padding: 10px;">
                        <i class="fa fa-book fa-3x" style="position: relative; border: solid 1px transparent;"></i>
                        <li class="header" style="position: relative; float: right; top: -30px;"> Total Students </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content" style="position: absolute; top: 27px; left: 730px; ">
                <!-- big buttons holder-->
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; display: inline;">
                    <ul class="nav" style="position: relative; border: solid 2px #696969; height: 100px; width: 150px; padding: 10px;">
                        <i class="fa fa-book fa-3x" style="position: relative; border: solid 1px transparent;"></i>
                        <li class="header" style="position: relative; float: right; top: 12px;"> Total Subjects </li>
                    </ul>
                </div>
            </div>

            </br>
			<h2>Quick Navigation</h2>
			<h5><hr ></hr></h5>
								 
        </div><!-- /.nav-tabs-custom -->
    </section><!-- /.Left col -->

</div><!-- /.row (main row) -->

@stop

@section('after-footer')s
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
@stop
