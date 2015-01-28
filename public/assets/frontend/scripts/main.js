var util = {
    Global:{
        init: function() {
            var e = this;
            
            e.hotspot();
            e.singlePageNav();
            e.ajaxSubmit();


            $( ".toggle-trigger" ).click(function(e) {
              $( ".toggle-content" ).toggleClass( "open" );
              $( ".toggle-actions" ).toggleClass( "open" );
              e.preventDefault();
            });


            $('.nav a').on('click', function(){ 
                if($('.navbar-toggle').css('display') !='none'){
                    $(".navbar-toggle").trigger( "click" );
                }
            });

            $('.nav-tabs > li a').on('click', function(e){
                alert();
                e.preventDefault();
            });

        },

        hotspot: function() {

            jQuery(document).ready(function($){
                //open interest point description   
                $('.cd-single-point').children('a').on('click', function(){
                    var selectedPoint = $(this).parent('li');
                    if( selectedPoint.hasClass('is-open') ) {
                        //selectedPoint.removeClass('is-open').addClass('visited');
                        selectedPoint.removeClass('is-open');
                    } else {
                        //selectedPoint.addClass('is-open').siblings('.cd-single-point.is-open').removeClass('is-open').addClass('visited');
                        selectedPoint.addClass('is-open').siblings('.cd-single-point.is-open').removeClass('is-open');
                    }
                });
                //close interest point description
                $('.cd-close-info').on('click', function(event){
                    event.preventDefault();
                    //$(this).parents('.cd-single-point').eq(0).removeClass('is-open').addClass('visited');
                    $(this).parents('.cd-single-point').eq(0).removeClass('is-open');
                });
            });

        },
        
        singlePageNav:function() {

            $('.single-page-nav').singlePageNav({
                offset: $('.single-page-nav:after').outerHeight()  + 60,
                filter: ':not(.external)',
                updateHash: true,
                beforeStart: function() {
                    // console.log('begin scrolling');
                },
                onComplete: function() {
                    //console.log('done scrolling');
                }

            });

        },



        ajaxSubmit: function() {

            $('#auk-tgr').click(function() {

              $('#tsitname').val('TSIT-AUK');
              $('#tsitprice').val('$920');

            });

            $('#auk-aleads').click(function() {

              $('#tsitname').val('TSIT-ALEADS');
              $('#tsitprice').val('$1680');

            });

            $('#form-tsit').submit(function(e){

                e.preventDefault();
                var passed  = $(this).validationEngine('validate');

                if (!passed) {
                  return;
                }

                $.ajax({
                    url : 'includes/tsit-form.php',
                    type : 'post',
                    data : $(this).serialize() ,
                    dataType: 'json',
                    asynce: false,
                    beforeSend:function() {
                        $('div.box-white').before('<span class="loading"></span>');
                    },
                    success:function(data){
                        if ( data.result === "ok" ){
                            setTimeout(function(){
                                $('#form-tsit').get(0).reset();
                            },1500);
                            
                            $('#contact-form').hide();
                            $('span.loading').remove();
                            $('#contact-message').addClass('is-success');
                            $('#contact-message').html('<p>Thank you for your interest. One of our friendly customer service officers will contact you within the next 48 working hours to finalise the order.</p>').show();

                            return;

                        }

                    }

                });
                return false;
            });

        }

    }
};


$(window).ready(function () {
    util.Global.init();
});



