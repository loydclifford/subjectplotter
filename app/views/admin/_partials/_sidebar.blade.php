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
                <a href="{{ admin_url('/') }}" data-url='["^/admin$","^/admin/dashboard$"]'>
                    <i class="fa fa-dashboard"></i> <span>{{ lang('texts.dashboard') }}</span>
                </a>
            </li>

            <li class="tree-separator">Users</li>


            {{-- Users/User --}}
            @if (can('manage_user'))
                <li class="treeview">
                    <a href="{{ admin_url('/user') }}" data-url="^/admin/users/[0-9]+">
                        <i class="fa  fa-group"></i>
                        <span>Users</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a data-url="^/admin/users" href="{{ admin_url('/users') }}"><i class="fa fa-angle-double-right"></i> All </a></li>
                        <li><a data-url="^/admin/users/create$" href="{{ admin_url('/users/create') }}"><i class="fa fa-angle-double-right"></i>Create</a></li>
                    </ul>
                </li>
            @endif

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>