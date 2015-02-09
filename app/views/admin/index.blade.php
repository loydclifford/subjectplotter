@extends('admin._partials._layout')

@section('main-content')
<div class="row">
   <div class="col-lg-6">
    <div class="input-group">
      <div class="input-group-btn meo_year"><h3>Filter Status</h3>
          <select name="--select Year--" id="sy">
              <option > --Select School Year-- </option>
              <option > 2009-2010 </option>
              <option > 2010-2011 </option>
              <option > 2011-2012 </option>
              <option > 2012-2013 </option>
              <option > 2013-2014 </option>
              <option > 2014-2015 </option>   
          </select>

          <select name="--select Year--" id="sem">
              <option > --Select Semester-- </option>
              <option > 1st Semester </option>
              <option > 2st Semester </option>   
          </select>

          <div class="btn-group meo_btn" role="group" aria-label="...">
              <button type="button" class="btn btn-primary" >Apply</button>
          </div>
      </div><!-- /btn-group -->
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.last-row -->



<div class="row"><!-- Main row -->
   
        <!-- Custom tabs (Charts with tabs)-->
        <div class="nav-tabs-custom romeo_head">
            <div class="tab-content">
                <!-- big buttons holder-->
                <div class="chart tab-pane meo_body" id="revenue-chart" style="position: relative; display: inline; color: rgba(20,20,20,.8);">
                    
                    <ul class="nav meo_courses" >
                        <i class="fa fa-book fa-3x" style="position: relative; border: solid 1px transparent;"></i>
                        <li class="header" style="position: relative; float: right; top: 12px; left: 4px; "><strong>Total Courses</strong> </li>
                    </ul>
                             
        
                    <ul class="nav meo_teachers">
                        <i class="fa fa-user fa-3x" style="position: relative; border: solid 1px transparent;"></i>
                        <li class="header" style="position: relative; float: right; top: 12px; left: 4px; "><strong>Total Teachers</strong> </li>
                    </ul>
              
                    <ul class="nav meo_students">
                        <i class="fa fa-user fa-3x" style="position: relative; border: solid 1px transparent;"></i>
                        <li class="header" style="position: relative; float: right; top: 12px; left: 4px; "><strong>Total Students</strong> </li>
                    </ul>
          
                    <ul class="nav meo_subjects">
                        <i class="glyphicon glyphicon-list-alt fa-3x" style="position: relative; border: solid 1px transparent;"></i>
                        <li class="header" style="position: relative; float: right; top: 12px; "><strong>Total Subjects</strong> </li>
                    </ul>

                
                </div>
            </div>			 
        </div><!-- /.nav-tabs-custom -->
    <!-- /.Left col -->
</div><!-- /.row (main row) -->


<div class="page-header navigation">
  <h3>Quick Navigation</h3>
</div>

<button type="button" class="btn btn-default btn-lg active manage_rooms">
<span class="glyphicon glyphicon-list" aria-hidden="true"></span> Manage Rooms</button>

<button type="button" class="btn btn-default btn-lg active manage_subjects">
<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Manage Subjects</button>

<button type="button" class="btn btn-default btn-lg active manage_teachers">
<span class="glyphicon glyphicon-user" aria-hidden="true"></span> Manage Teachers</button>

<button type="button" class="btn btn-default btn-lg active manage_student">
<span class="glyphicon glyphicon-user" aria-hidden="true"></span> Manage Students</button>

<button type="button" class="btn btn-default btn-lg active manage_courses">
<span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> Manage Courses</button>

<button type="button" class="btn btn-default btn-lg active subject_schedule">
<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Subject Schedule</button>

<button type="button" class="btn btn-default btn-lg active grade_entry">
<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span> Grade Entry</button>

<nav>
  <ul class="pagination page">
    <li>
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>



                
@stop

@section('after-footer')s
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
@stop
