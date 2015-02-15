<!DOCTYPE html>
<html>
<head lang="{{-- App::getLocale() --}}">
    <meta charset="UTF-8">
    <title>{{ $meta->title_prefix . $meta->title . $meta->title_suffix; }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- bootstrap 3.0.2 -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/bootstrap.css') }}">
    <!-- jQuery UI 1.10.3 Skin -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/jQueryUI/bootstrap/jquery.ui.1.10.3.ie.css') }}">
    <link rel="stylesheet" href="{{ asset_url('/admin/css/jQueryUI/bootstrap/jquery-ui-1.10.3.custom.css') }}">
    <link rel="stylesheet" href="{{ asset_url('/admin/css/jQueryUI/bootstrap/jquery-ui-1.10.3.theme.css') }}">
    <!-- font Awesome -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/font-awesome.min.css?v=4.2.0') }}">
    <!-- select2 3.5.1 -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset_url('/admin/css/select2/select2-bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset_url('/admin/js/plugins/select2/plugins/placecomplete/jquery.placecomplete.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/ionicons.min.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/morris/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/jvectormap/jquery-jvectormap-1.2.2.css') }}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/fullcalendar/fullcalendar.css') }}">
    <!-- Time picker -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/timepicker/bootstrap-timepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset_url('/admin/css/daterangepicker/daterangepicker-bs3.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/adminlte.css') }}">
    <!-- Flow Player skin -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/flowplayer-5.4.6/minimalist.css') }}">
    <!-- Carsnow Main Style  -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/carsnow.css') }}">
    <!-- ROMEO Style  -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/romeo.css') }}">
    <!-- JEREMY Style  -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/jeremy.css') }}">

    <!-- jQuery 2.0.2 -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- Include dynamic js data -->
    @include('admin._partials._scripts')
</head>

{{-- <body class="skin-black|skin-blue fixed"> --}}
<body class="skin-blue">
    @yield('before-header')

    @include('admin._partials._header')

    @yield('after-header')

    <div class="wrapper row-offcanvas row-offcanvas-left">

        @include('admin._partials._sidebar')

        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">

                @section('main-content-header')
                <h1>
                    Dashboard
                    <small>Control panel</small>
                </h1>
                @show

                <?php if ($enable_breadcrumb) : ?>
                {{ Html::breadcrumbs() }}
                <?php endif; ?>

            </section>

            <!-- Main content -->
            <section class="content">
                @include('admin._partials._notices._noscript')

                @yield('main-content')

            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

    @yield('before-footer')

    @include('admin._partials._footer')

    @yield('after-footer')
</body>
</html>