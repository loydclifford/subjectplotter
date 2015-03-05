
<!-- header logo: style can be found in header.less -->
<header class="header">
    <a href="{{admin_url('/dashboard')}}" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        Subject Plotter
    </a>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
<!-- Sidebar toggle button-->
<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</a>
<div class="navbar-right">
<ul class="nav navbar-nav">
<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">

    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="glyphicon glyphicon-user"></i>
        <span>{{ user_get()->present()->getDisplayName() }} ({{ User::USER_TYPE_DEAN == user_get()->user_type ? "Dean" : "Admin" }}) <i class="caret"></i></span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header bg-light-blue">
            <img src="{{ url('/assets/admin/images/avatar3.png') }}" class="img-circle" alt="User Image">
            <p>
                {{ user_get()->present()->getDisplayName() }}
            </p>
        </li>
        <!-- Menu Body -->

        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
                <a href="{{ admin_logout_url(); }}" class="btn btn-default btn-flat">Sign out</a>
            </div>
        </li>
    </ul>
</li>
</ul>
</div>
</nav>
</header>
