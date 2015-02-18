
<script src="{{ asset_url('/public/scripts/jquery-1.9.1.min.js') }}"></script>
<script src="{{ asset_url('/public/scripts/bootstrap.min.js') }}"></script>
<script src="{{ asset_url('/public/scripts/tabs-addon.js') }}"></script>
<script src="{{ asset_url('/public/scripts/plugins/DataTables-1.10.5/media/js/jquery.dataTables.min.js') }}"></script>
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
<!-- Time Picker -->
<script src="{{ asset_url('/admin/js/plugins/timepicker/bootstrap-timepicker.js') }}"></script>
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
<!-- Custom Parsely validator -->
<script src="{{ asset_url('/admin/js/parsely.validator.js') }}"></script>
<!-- Local JS: Utils App -->
<script src="{{ asset_url('/admin/js/utils.js') }}"></script>
<!-- Local JS: Script Handlers App -->
<script src="{{ asset_url('/admin/js/scripts.js') }}"></script>


<script type="text/javascript">
    $(function ()
    {
        $("a[href^='#demo']").click(function (evt)
        {
            evt.preventDefault();
            var scroll_to = $($(this).attr("href")).offset().top;
            $("html,body").animate({ scrollTop: scroll_to - 80 }, 600);
        });
        $("a[href^='#bg']").click(function (evt)
        {
            evt.preventDefault();
            $("body").removeClass("light").removeClass("dark").addClass($(this).data("class")).css("background-image", "url('bgs/" + $(this).data("file") + "')");
            console.log($(this).data("file"));


        });
        $("a[href^='#color']").click(function (evt)
        {
            evt.preventDefault();
            var elm = $(".tabbable");
            elm.removeClass("grey").removeClass("dark").removeClass("dark-input").addClass($(this).data("class"));
            if (elm.hasClass("dark dark-input"))
            {
                $(".btn", elm).addClass("btn-inverse");
            }
            else
            {
                $(".btn", elm).removeClass("btn-inverse");

            }

        });
        $(".color-swatch div").each(function ()
        {
            $(this).css("background-color", $(this).data("color"));
        });
        $(".color-swatch div").click(function (evt)
        {
            evt.stopPropagation();
            $("body").removeClass("light").removeClass("dark").addClass($(this).data("class")).css("background-color", $(this).data("color"));
        });
        $("#texture-check").mouseup(function (evt)
        {
            evt.preventDefault();

            if (!$(this).hasClass("active"))
            {
                $("body").css("background-image", "url(bgs/n1.png)");
            }
            else
            {
                $("body").css("background-image", "none");
            }
        });

        $("a[href='#']").click(function (evt)
        {
            evt.preventDefault();

        });

        $("a[data-toggle='popover']").popover({
            trigger:"hover",html:true,placement:"top"
        });
    });

</script>