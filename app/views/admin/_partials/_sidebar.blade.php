<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ url('/assets/admin/images/avatar3.png') }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Hello, {{ user_get()->present()->getDisplayName() }}</p>
                <a href="{{ user_get()->present()->getProfileUrl() }}">Edit acount </a>
            </div>
        </div>

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" id="active_menu">

            {{-- DASHBORD --}}
            <li>
                <a href="{{ admin_url('/dashboard') }}" data-url='["^/admin$","^/admin/dashboard$"]'>
                    <i class="fa fa-dashboard"></i> <span>{{ lang('texts.dashboard') }}</span>
                </a>
                <li class="treeview">
                    <a href="{{ admin_url('/courses') }}" data-url="^/admin/courses/[0-9]+">
                        <i class="fa  fa-group"></i>
                        <span>Courses</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a data-url="^/admin/courses" href="{{ admin_url('/courses') }}"><i class="fa fa-angle-double-right"></i> All </a></li>
                        <li><a data-url="^/admin/courses/create$" href="{{ admin_url('/courses/create') }}"><i class="fa fa-angle-double-right"></i>Create</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="{{ admin_url('/rooms') }}" data-url="^/admin/rooms/[0-9]+">
                        <i class="fa  fa-group"></i>
                        <span>Rooms</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a data-url="^/admin/rooms" href="{{ admin_url('/rooms') }}"><i class="fa fa-angle-double-right"></i> All </a></li>
                        <li><a data-url="^/admin/rooms/create$" href="{{ admin_url('/rooms/create') }}"><i class="fa fa-angle-double-right"></i>Create</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="{{ admin_url('/subjects') }}" data-url="^/admin/subjects/[0-9]+">
                        <i class="fa  fa-group"></i>
                        <span>Subjects</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a data-url="^/admin/subjects" href="{{ admin_url('/subjects') }}"><i class="fa fa-angle-double-right"></i> All </a></li>
                        <li><a data-url="^/admin/subjects/create$" href="{{ admin_url('/subjects/create') }}"><i class="fa fa-angle-double-right"></i>Create</a></li>
                        <li><a data-url="^/admin/subjects/categories" href="{{ admin_url('/subjects/categories') }}"><i class="fa fa-angle-double-right"></i>Subject Categories</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="{{ admin_url('/teachers') }}" data-url="^/admin/teachers/[0-9]+">
                        <i class="fa  fa-group"></i>
                        <span>Teachers</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a data-url="^/admin/teachers" href="{{ admin_url('/teachers') }}"><i class="fa fa-angle-double-right"></i> All </a></li>
                        <li><a data-url="^/admin/teachers/create$" href="{{ admin_url('/teachers/create') }}"><i class="fa fa-angle-double-right"></i>Create</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="{{ admin_url('/students') }}" data-url="^/admin/students/[0-9]+">
                        <i class="fa  fa-group"></i>
                        <span>Students</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a data-url="^/admin/students" href="{{ admin_url('/students') }}"><i class="fa fa-angle-double-right"></i> All </a></li>
                        <li><a data-url="^/admin/students/create$" href="{{ admin_url('/students/create') }}"><i class="fa fa-angle-double-right"></i>Create</a></li>
                    </ul>
                </li>
                <li >
                    <a href="{{ admin_url('/grade-entry') }}" data-url="^/admin/grade-entry/[0-9]+">
                        <i class="fa  fa-group"></i>
                        <span>Grade Entry</span>
                    </a>
                </li>
                <li >
                    <a href="{{ admin_url('/subject-schedule') }}" data-url="^/admin/subject-schedule/[0-9]+">
                        <i class="fa  fa-group"></i>
                        <span>Subject Schedule</span>
                    </a>
                </li>
            </li>

            <li class="tree-separator">Notifications</li>

            {{-- Users/User --}}
            <li >
                <a href="{{ admin_url('/schedule-requests') }}" data-url="^/admin/schedule-requests/[0-9]+">
                    <i class="fa  fa-group"></i>
                    <span>Schedule Requests</span>
                </a>
            </li>

            <li class="tree-separator">Settings</li>

            <li class="treeview">
                <a href="{{ admin_url('/users') }}" data-url="^/admin/users/[0-9]+">
                    <i class="fa  fa-group"></i>
                    <span>Users</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a data-url="^/admin/users" href="{{ admin_url('/users') }}"><i class="fa fa-angle-double-right"></i> All </a></li>
                    <li><a data-url="^/admin/users/create$" href="{{ admin_url('/users/create') }}"><i class="fa fa-angle-double-right"></i>Create</a></li>
                </ul>
            </li>

            <li >
                <a href="{{ admin_url('/settings') }}" data-url="^/admin/settings/[0-9]+">
                    <i class="fa  fa-group"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="tree-separator">&nbsp;</li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>