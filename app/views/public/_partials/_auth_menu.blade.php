<ul class="nav nav-tabs">
    <li class="{{ $active_menu == 'login' ? 'active' : NULL }}"><a href="{{ url('/login') }}"  class=" "><i class="icon-lock"></i>&nbsp;<span>Login Panel</span></a></li>
    <li class="{{ $active_menu == 'forgot' ? 'active' : NULL }}"><a href="{{ url('/forgot') }}" ><i class="icon-key"></i>&nbsp;<span>Forgot Password</span></a></li>
</ul>