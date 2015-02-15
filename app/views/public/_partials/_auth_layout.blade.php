<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <title>{{ $meta->title_prefix . $meta->title; }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- bootstrap 3.0.2 -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/bootstrap.min.css') }}">
    <!-- font Awesome -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/font-awesome.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/adminlte.css?v=1.0.2') }}">
    <!-- Carsnow Main Style  -->
    <link rel="stylesheet" href="{{ asset_url('/admin/css/carsnow.css?v=1.1.1') }}">

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
<body class="bg-black skin-black">

    @include('admin._partials._notices')

    @yield('main-content')

    <!-- add new calendar event modal -->
    <!-- jQuery UI 1.10.3 -->
    <script src="{{ asset_url('/admin/js/libraries/jquery-ui-1.10.3.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset_url('/admin/js/libraries/bootstrap.min.js') }}"></script>
    <!-- Select2 3.5.1 -->
    <script src="{{ asset_url('/admin/js/plugins/select2/select2.min.js') }}"></script>
    <!-- PlaceComplete Select2 plugin -->
    <script src="{{ asset_url('/admin/js/plugins/select2/plugins/placecomplete/jquery.placecomplete.js') }}"></script>

    <!-- Morris.js charts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

    <script src="{{ asset_url('/admin/js/plugins/morris/morris.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset_url('/admin/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- jvectormap -->
    <script src="{{ asset_url('/admin/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset_url('/admin/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset_url('/admin/js/plugins/jvectormap/jquery-jvectormap-ph_regions-mill-en.js') }}"></script>
    <!-- fullCalendar -->
    <script src="{{ asset_url('/admin/js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset_url('/admin/js/plugins/jqueryKnob/jquery.knob.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset_url('/admin/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset_url('/admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- TBList Javascript -->
    <script src="{{ URL::to('/packages/nerweb/laravel-tblist/js/tblist.jquery.js') }}"></script>
    <!-- Bootbox Javascript -->
    <script src="{{ asset_url('/admin/js/plugins/bootbox/bootbox.js') }}"></script>
    <!-- Plupload Uploader -->
    <script src="{{ asset_url('/admin/js/plugins/plupload-2.1.2/js/plupload.full.min.js') }}"></script>
    <!-- Datepicker -->
    <script src="{{ asset_url('/admin/js/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <!-- Video Flowplayer -->
    <script src="{{ asset_url('/admin/js/plugins/flowplayer-5.4.6/flowplayer.min.js') }}"></script>
    <!-- CK Editor -->
    <script src="{{ asset_url('/admin/js/plugins/ckeditor/ckeditor.js') }}"></script>
    <!-- jQuery.areYouSure -->
    <script src="{{ asset_url('/admin/js/plugins/jquery.AreYouSure/jquery.are-you-sure.js') }}"></script>
    <!-- jQuery.Nestable -->
    <script src="{{ asset_url('/admin/js/plugins/jquery.nestable/jquery.nestable.js') }}"></script>

    <!-- Parsly JS-->
    <script src="{{ asset_url('/admin/js/plugins/parsley/parsley.min.js') }}"></script>
    <!-- Parsly JS -->
    <script src="{{ asset_url('/admin/js/plugins/parsley/parsley.remote.min.js') }}"></script>
    <!-- Google MAP API -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>

    <!-- Custom Parsely validator -->
    <script src="{{ asset_url('/admin/js/parsely.validator.js') }}"></script>
    <!-- adminlte App -->
    <script src="{{ asset_url('/admin/js/adminlte/app.js') }}"></script>
    <!-- Local JS: Utils App -->
    <script src="{{ asset_url('/admin/js/utils.js') }}"></script>
    <!-- Car DB API (Local Implementation) -->
    <script src="{{ asset_url('/admin/js/car_db_api.js') }}"></script>
    <!-- Local JS: Plupload Heleper App -->
    <script src="{{ asset_url('/admin/js/utils.plupload.js') }}"></script>
    <!-- Local JS: Plupload Heleper App -->
    <script src="{{ asset_url('/admin/js/utils.mediaUploader.js') }}"></script>
    <!-- Local JS: Script Handlers App -->
    <script src="{{ asset_url('/admin/js/scripts.js') }}"></script>
    <!-- Select MEDIA SCRIPTS: Script Handlers App -->
    <script src="{{ asset_url('/admin/js/selectMedia.js') }}"></script>

</body>
</html>