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
    <link href="{{ asset_url('/public/styles/fa/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset_url('/public/styles/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset_url('/public/scripts/plugins/DataTables-1.10.5/media/css/jquery.dataTables.css') }}" rel="stylesheet" />

    <!-- select2 3.5.1 -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset_url('/admin/css/select2/select2-bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset_url('/admin/js/plugins/select2/plugins/placecomplete/jquery.placecomplete.css') }}">

    <!-- jQuery 2.0.2 -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <style>
        .bootbox-body {
            color:black!important;
        }
        .dataTables_filter, .dataTables_info {
            display:none;
        }
    </style>
    <!--[if IE 7]>
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
        <div class="row-fluid" >
            <div class="span12  logo">
                <a href="{{ url('/dashboard') }}" ><i class="icon-calendar"></i>&nbsp;&nbsp;<span>Student Subject Plotter</span></a>
            </div>
        </div>
    </div>

    <div class="divider  hidden-desktop"></div>

    <div class="container">
        <div class="row-fluid" id="demo-1">
            <div class="span12 ">
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