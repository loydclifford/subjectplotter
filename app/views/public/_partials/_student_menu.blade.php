<ul class="nav nav-tabs">
    <li class="{{ $active_menu == 'dashboard' ? 'active' : NULL }}"><a href="{{ url('/dashboard') }}"  class=" "><i class="icon-home"></i>&nbsp;&nbsp;<span>Dashboard</span></a></li>
    <li class="{{ $active_menu == 'my-schedules' ? 'active' : NULL }}"><a href="{{ url('/my-schedules') }}" ><i class="icon-calendar"></i>&nbsp;&nbsp;<span>My Schedules</span></a></li>
    <li class="{{ $active_menu == 'accounts' ? 'active' : NULL }}"><a href="{{ url('/accounts') }}" ><i class="icon-user"></i>&nbsp;&nbsp;<span>Accounts</span></a></li>
    <li class="{{ $active_menu == 'contact' ? 'active' : NULL }}"><a href="{{ url('/contacts') }}" ><i class="icon-envelope-alt"></i>&nbsp;&nbsp;<span>Contact Admin</span></a></li>
    <li class=""><a href="{{ url('/logout') }}" ><i class="icon-lock"></i>&nbsp;<span>Logout</span></a></li>
</ul>