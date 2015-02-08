
@include('admin._partials._messages')

<br />
<ul class="nav nav-tabs">
    <li role="presentation" class="{{ $current_tab == 'general' ? 'active' : NULL  }}"><a href="{{ admin_url('/settings') }}">General</a></li>
    <li role="presentation" class="{{ $current_tab == 'semester' ? 'active' : NULL  }}"><a href="{{ admin_url('/settings/semester') }}">Semester</a></li>
</ul>

<br />
<br />