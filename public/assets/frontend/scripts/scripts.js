/*!
 * Author: Rex Taylor
 * Date: 29 August 2014
 * Description:
 *      This file should be included in all pages
 !**/
$(function () {
    'use strict';

    /**
     * Sometimes we need to normalize plugin bugs or missing functionality
     * for the sake of the business role.
     *
     * Note! this must be included before the js scripts where plugin is
     * being initialized
     */

    // Tabs Fixes for twitter bootstrap
    // Javascript to enable link to tab
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href=#' + url.split('#')[1] + ']').tab('show');
    }

    // Change hash for page-reload
    $('.nav-tabs a').on('click', function (e) {
        window.location.hash = e.target.hash;
    });


    // This will fix the bug on .serialize(). form submitted or clicked button
    // that has a name and value on it through ajax
    // is not included in the POST or GET data. So we need to manually append the
    // input as hidden in the form with the value of the name and value
    // before it gets submitted.
    /*$("body").delegate('button[type=submit].btn_submit', 'click', function (e) {
        var $btn = $(this),
            $form = $btn.closest('form'),
            name = $btn.attr('name'),
            value = $btn.attr('value');

        if (typeof name != 'undefined') {
            // remove previously remove item.
            $form.find('.temp_input').remove();

            if (!$form.find('input[name=' + name + ']').length) {
                $form.prepend('<input class="temp_input" type="hidden" name="' + name + '" value="' + value + '">');
            }
        }
    });*/

    // modal fixes, when trying to show hide and show other modal from
    // the same modal. then you need to do another workaround instead of adding
    // data-dismiss="modal" attribute to anchor tag. instead, add the class .js-close-other-modal.
    // see: <a class="js-close-other-modal"  href="#modal-signup"><span>Sign up here</span></a>
    $('body').delegate('.js-close-other-modal', 'click', function() {
        var $this = $(this);
        $this.closest('.modal').modal('hide').one('hidden.bs.modal', function() {
            $($this.attr('href')).modal('show');
        });
    });

    // Show Cookie Message if cookie is disabled
    if (!utils.isCookiesEnabled()) {
        $('.nocookie').show();
    }

    // Global Ajax Handlers For Possible Errors
    $(document).ajaxComplete(function (event, xhr, settings) {
        if (xhr.status) {
            switch (xhr.status) {
                case 404:
                    // @todo 404 alert
                    break;
                case 500:
                    // @todo 500 alert
                    break;
                case 401:
                    // NOTE! Below should have 401 code response
                    if ($.isDefined(xhr.responseJSON.status)) {
                        console.log(xhr.responseJSON.status);
                        switch (xhr.responseJSON.status) {
                            case utils.result.RESULT_INVALID_TOKEN:
                                utils.errorInvalidToken();
                                break;
                            case utils.result.RESULT_NOT_LOG_IN:
                                utils.errorNotLoggedIn();
                                break;
                        }
                    }
                    break;
            }
        }
    });

    //  Media Helper
    // $(".video-player").flowplayer();

    // Bootstrap Datepicker
    //$('.date-picker,.input-daterange').datepicker({
    //    todayBtn: true,
    //    autoclose: true,
    //    todayHighlight: true,
    //    format: utils.config.date_picker_format,
    //    forceParse: false
    //});

    // jQuery.areYouSure
    // https://github.com/codedance/jquery.AreYouSure
    $('form.form-check-ays').areYouSure();


    // parsley jquery
    // @url: http://parsleyjs.org/doc/index.html#psly-ui-for-form
    $(".parsley-form").parsley({
        successClass: "--has-success",
        errorClass: "has-error",
        classHandler: function (el) {
            return el.$element.closest(".form-group");
        },
        errorsContainer: function (el) {
            return el.$element.closest(".form-group");
        },
        errorsWrapper: "<span class='help-block'></span>",
        errorTemplate: "<span></span>"
    });

    //Parseley Jquery Show Which Tab should display
    function showTabWrapperForFieldError($form) {
        // if not defined then search for all the forms
        if ( ! $.isDefined($form) ) {
            $form = $('form');

            $form.each(function(index) {
                var $this = $(this);

                showTabWrapperForFieldError($this);
            });

            return ;
        }

        var $whichFocus = $form.find('.form-group.has-error').first();

        // if has tab pane init then, focus it
        var $whichTabPane = $whichFocus.closest('.tab-pane');
        if ($whichTabPane.length) {
            var idStr = $whichTabPane.attr('id');

            // find the element that target this id
            var $tabToggler = $('[data-target="#'+idStr+'"]');
            if ($tabToggler.length) {
                $tabToggler.trigger('click');
            }
        }
    }

    // Fix tab showing validation
    $.listen('parsley:form:validated', function(Parsley) {
        showTabWrapperForFieldError(Parsley.$element);
    });

    // do show tab on load from form if it has error
    showTabWrapperForFieldError();




});
