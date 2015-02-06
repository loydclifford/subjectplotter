@extends('admin._partials._layout')

@section('main-content')
<div class="row"><p>Filter Status</p>
   <div class="col-lg-6">
    <div class="input-group">
      <input style="position: relative; width: 150px; left: 200px;" type="text" class="form-control" aria-label="...">
      <div class="input-group-btn meo_year">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">S/Y<span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">
          <li><a href="#">2009-10</a></li>
          <li><a href="#">2010-11</a></li>
          <li><a href="#">2011-12</a></li>
          <li><a href="#">2012-13</a></li>
        </ul>
      </div><!-- /btn-group -->
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->

  <div class="col-lg-6">
    <div class="input-group">
      <input type="text" class="form-control" aria-label="...">
      <div class="input-group-btn meo_semester">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Sem<span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu">
          <li><a href="#">1st Sem</a></li>
          <li><a href="#">2nd Sem</a></li>
          
        </ul>
      </div><!-- /btn-group -->
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.last-row -->

<div class="row"><!-- Main row -->
   
        <!-- Custom tabs (Charts with tabs)-->
        <div class="nav-tabs-custom romeo_head">
            <div class="tab-content">
                <!-- big buttons holder-->
                <div class="chart tab-pane meo_body" id="revenue-chart" style="position: relative; display: inline;">
                    
                    <ul class="nav meo_courses" >
                        <i class="fa fa-book fa-3x" style="position: relative; border: solid 1px transparent;"></i>
                        <li class="header" style="position: relative; float: right; top: 12px;"> Total Courses </li>
                    </ul>
                             
        
                    <ul class="nav meo_teachers">
                        <i class="glyphicon glyphicon-user" style="position: relative; border: solid 1px transparent;"></i>
                        <li class="header" style="position: relative; float: right; top: 12px;"> Total Teachers </li>
                    </ul>
              
                    <ul class="nav meo_students">
                        <i class="fa fa-book fa-3x" style="position: relative; border: solid 1px transparent;"></i>
                        <li class="header" style="position: relative; float: right; top: -30px;"> Total Students </li>
                    </ul>
          
                    <ul class="nav meo_subjects">
                        <i class="fa fa-book fa-3x" style="position: relative; border: solid 1px transparent;"></i>
                        <li class="header" style="position: relative; float: right; top: 12px;"> Total Subjects </li>
                    </ul>

                
                </div>
            </div>			 
        </div><!-- /.nav-tabs-custom -->
    <!-- /.Left col -->
</div><!-- /.row (main row) -->
                
@stop

@section('after-footer')s
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
@stop
