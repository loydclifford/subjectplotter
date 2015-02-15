<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head lang="{{ App::getLocale() }}">
    <meta charset="UTF-8">
    <title>{{ $meta->title_prefix . $meta->title . $meta->title_suffix; }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- bootstrap 3.0.2 -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/bootstrap.css') }}">
    <link href="{{ asset_url('/public/styles/bootstrap-responsive.min.css') }}" rel="stylesheet" />
    <link href="{{ asset_url('/public/css/preview.min.css') }}" rel="stylesheet" />
    <link href="{{ asset_url('/public/css/custom.css') }}" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css' />
    <link href="{{ asset_url('/public/styles/font-awesome.min.css') }}" rel="stylesheet" />

    <!--[if IE 7]>
    <link href="{{ asset_url('/styles/font-awesome-ie7.min.css') }}" rel="stylesheet" />
    <![endif]-->
    <!--[if IE 8]>
    <style type="text/css">
        .navbar-inner{
            filter:none;
        }
    </style>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    @include('admin._partials._scripts')
</head>
<body class="">
    <div class="divider"></div>
    <div class="container">
        <div class="row-fluid" id="demo-1">
            <div class="span10 offset1 logo">
                <a href="{{ url('/dashboard') }}" ><i class="icon-calendar"></i>&nbsp;&nbsp;<span>Student Subject Plotter</span></a>
            </div>
        </div>
    </div>

    <div class="divider  hidden-desktop"></div>

    <div class="container">
        <div class="row-fluid" id="demo-1">
            <div class="span10 offset1">
                <div class="tabbable custom-tabs tabs-animated  flat flat-all hide-label-980 shadow track-url auto-scroll">
                    @if (!user_check() )
                        @include('public._partials._auth_menu')
                    @elseif (user_get()->user_type == User::USER_TYPE_STUDENT)
                        @include('public._partials._student_menu')
                    @elseif (user_get()->user_type == User::USER_TYPE_INSTRUCTOR)
                        @include('public._partials._instructor_menu')
                    @endif

                    <div class="tab-content ">
                        <div class="tab-pane active" id="panel1">
                            @yield('main-content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('before-footer')
    @include('public._partials._footer')
    @yield('after-footer')

</body>
</html>