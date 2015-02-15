
<script src="{{ asset_url('/public/scripts/jquery-1.9.1.min.js') }}"></script>
<script src="{{ asset_url('/public/scripts/bootstrap.min.js') }}"></script>
<script src="{{ asset_url('/public/scripts/tabs-addon.js') }}"></script>
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