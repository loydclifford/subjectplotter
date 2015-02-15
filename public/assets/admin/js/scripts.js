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
    $("body").delegate('button[type=submit].btn_submit', 'click', function (e) {
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
    });


    // Global page
    var $notificationMenu = $('.notifications-menu');
    $notificationMenu.find('.dropdown-toggle').click(function () {
        var $lis = $notificationMenu.find('.dropdown-menu .menu > li');

        var activityIds = [];

        $lis.each(function ($index) {
            if ($(this).data('is-read') == 0) {
                activityIds.push($(this).data('id'));
            }
        });

        $.ajax({
            type: 'GET',
            url: utils.adminUrl('/activities/mark-read'),
            data: {
                id: activityIds
            },
            dataType: 'json',
            success: function () {
                $lis.each(function ($index) {
                    $(this).data('is-read', 1);
                });
            }
        });
        console.log(activityIds);
    });

    /*
     * Show Cookie Message if cookie is disabled
     * ---------------------------------------------
     *
     !**/
    if (!utils.isCookiesEnabled()) {
        $('.nocookie').show();
    }


    /*
     * Global Ajax Handlers For Possible Errors
     * ---------------------------------------------
     *
     !**/
    $(document).ajaxComplete(function (event, xhr, settings) {

        if (xhr.status) {
            switch (xhr.status) {
                case 404:
                    utils.error404();
                    break;
                case 500:
                    utils.error500();
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

    /*
     * Bootbox
     * ---------------------------------------------
     * class: confirm_action
     !**/
    $('body').delegate('.confirm_action', 'click', function (e) {
        var $this = $(this),
            qMssage = $this.data('message');

        bootbox.confirm(qMssage, function (result) {
            if (result === true) {
                utils.redirect($this.attr('href'));
            }
        });

        e.preventDefault();
    });


    /*
     * Tblist Global Configuration
     * ---------------------------------------------
     !**/
    $(".js-tblist-default").tblist({
        start: function () {
            return false;
        },
        end: function () {
            return false;
        },
        onSelect: function () {
            return false;
        },
        table: ".table-list",
        perPage: ".per-page",
        pagination: ".pagination",
        paginationInfo: ".pagination-info",
        ajaxSubmitEnabled: true
    });

    /*
     * Add active class to menu and trees
     * ---------------------------------------------
     * Dashboard sidebar add active class
     * it uses regexp to match url, see http://www.w3schools.com/jsref/jsref_obj_regexp.asp
     *
     * Example:
     * 	multiple url to filter: data-url='["^/admin/pages/[0-9]+","^/admin/pages$"]'
     *  single-url to filter: data-url="^/admin/pages/[0-9]+"
     *
     !**/

    var $activeMenu = $("#active_menu"),
        locationPath = window.location.pathname;

    $activeMenu.find('a[data-url]').each(function (index) {
        var $this = $(this),
            activeUrl = $this.data('url');

        if ($.isEmpty(activeUrl)) {
            return;
        }

        if ($.isString(activeUrl)) {
            activeUrl = [activeUrl];
        }

        for (var i in activeUrl) {
            var str = activeUrl[i];
            var result = locationPath.match(str);
            if (result !== null) {
                // then string url is found
                var treeViewMenu = $this.closest('.treeview-menu'),
                    treeView = $this.closest('.treeview');

                if (treeViewMenu.length) {
                    $this.closest('li').addClass('active');
                }

                if (treeView.length) {
                    treeView.children('a').trigger('click');
                }
                else {
                    $this.closest('li').addClass('active');
                }

                return false;
            }
        }
    });

    /*
     * Media Helper
     * ---------------------------------------------
     !**/
    $(".video-player").flowplayer();


    /*
     * Select 2 3.5.1
     * ---------------------------------------------
     !**/
    $('.select2-select').select2({
        allowClear: true
    });


    /*
     * Select2 for customer picker
     * ---------------------------------------------
     !**/
    var $search = new utils.searchUser($('.select2-select-user'));
    $search.placeholder = utils.lang.search_customer;
    $search.init();

    /*
     * Bootstrap Datepicker
     * ---------------------------------------------
     !**/
    $('.date-picker,.input-daterange').datepicker({
        todayBtn: true,
        autoclose: true,
        todayHighlight: true,
        format: utils.config.date_picker_format,
        forceParse: false
    });


    //====================================================================================================================

    /*
     * initial ck Editor
     * ---------------------------------------------
     !**/
    // Simple
    if ($('#wysiwyg_simple').length) {
        CKEDITOR.replace('wysiwyg_simple');
    }
    if ($('#wysiwyg_simple_2').length) {
        CKEDITOR.replace('wysiwyg_simple_2');
    }

    // Advanced
    if ($('#wysiwyg_advanced').length) {
        CKEDITOR.replace('wysiwyg_advanced');
    }
    if ($('#wysiwyg_advanced_2').length) {
        CKEDITOR.replace('wysiwyg_advanced_2');
    }

    /*
     * jQuery.areYouSure
     * ---------------------------------------------
     * @url: https://github.com/codedance/jquery.AreYouSure
     !**/
    $('form.form-check-ays').areYouSure();


    /*
     * parsley jquery
     * ---------------------------------------------
     * @url: http://parsleyjs.org/doc/index.html#psly-ui-for-form
     !**/
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

    $('.timepicker1').timepicker({
        defaultTime: '07:00 AM',
        minuteStep: 30,
        showSeconds: false,
        showMeridian: true,
        template: 'dropdown'
    });


});
