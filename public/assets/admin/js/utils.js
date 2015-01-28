/*!
 * Author: Rex Taylor
 * Date: 29 August 2014
 * Description:
 *      This file should be included in all pages
 !**/

"use strict";

var utils = typeof utils === 'undefined' ? [] : utils;

// Extend jquery Helper
$.isObject = function ($object) {
    return typeof $object === 'object';
}

$.isDefined = function (data) {
    return typeof data !== 'undefined';
}

$.isString = function (data) {
    return typeof data === 'string';
}

$.isEmpty = function (data) {
    if (typeof data === 'object') {
        if (data.length <= 0) {
            return true;
        }
    }
    else {
        if (data === '') {
            return true;
        }
    }

    // If passed all the empty then return True
    return false;
}

$.strpos = function (haystack, needle, offset) {
    //  discuss at: http://phpjs.org/functions/strpos/
    var i = (haystack + '')
        .indexOf(needle, (offset || 0));
    return i === -1 ? false : i;
}

/**
 * Create an input index name
 *
 * @param $objects    - the ojbect to be count
 * @param inputName - 'products[{0}][product_name'
 */
utils.resetInputIndex = function ($objects) {
    // Store all input names
    var inputNames = [];

    $objects.first().find('input,select,textarea').each(function () {
        var name = $(this).attr('name');

        if (typeof name != 'undefined' && $.trim(name) != "") {
            inputNames.push(name);
        }
    });

    // Reset Index
    $objects.each(function (index) {

        // Find each name
        for (var x in inputNames) {
            var extracted = inputNames[x].split(/\[[0-9]+?\]/);

            var group = extracted[0];           // dividend
            var itemIndex = '[' + index + ']';  // [0] | [1] | [2]
            var realField = extracted[1];   // [company]

            var indexFullName = group + itemIndex + realField;

            // Rename name
            $(this).find('[name$="' + realField + '"]').attr('name', indexFullName);
        }

    });
}


utils.error404 = function () {
    bootbox.alert(utils.lang.not_found);
}

utils.error500 = function () {
    bootbox.alert(utils.lang.internal_error);
}

utils.error403 = function () {
    bootbox.alert(utils.lang.permission_denied);
}

utils.errorNotLoggedIn = function () {
    var message = '<p>'+utils.lang.not_login+'</p>';
        message += '<br />';
        message += '<p><a href="'+utils.adminUrl('/login')+'" title="'+utils.lang.login_label+'" class="btn btn-primary">'+utils.lang.login_label+'</a></p>'

    bootbox.alert(message);
}

utils.errorInvalidToken = function () {
    bootbox.alert(utils.lang.token_mismatched);
}


// Create message
utils.createCallout = function (title, message, calloutType) {
    var $markup = '<div class="callout callout-' + calloutType + '">';
    if (title == "" || !$.isDefined(title)) {
        $markup += '<h4>' + title + '</h4>';
    }
    $markup += '<p>' + message + '</p>';
    $markup += '</div>';

    return $markup;
}

utils.createAlert = function (message, alertType) {

    var faClass = {
        danger: 'fa-ban',
        info: 'fa-info',
        warning: 'fa-warning',
        check: 'fa-check',
    };

    var $markup = '<div class="alert alert-' + alertType + ' alert-dismissable">';
    $markup += '<i class="fa ' + faClass[alertType] + '"></i>';
    $markup += '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>';
    $markup += message;
    $markup += '</div>';

    return $markup;
}


utils.redirect = function (url) {
    if ($.isDefined(url)) {
        // Prevent areYouSure Popup when system is
        // redirecting the form
        // $form.areYouSure( {'silent':true} );
        if (url == window.location.href) {
            return window.location.reload();
        }

        if ($.strpos(url, '#')) {
            window.location.href = url;

            return window.location.reload();
        }

        return window.location = url;
    }
}

utils.newTab = function (url) {
    window.open(url, "_blank");
}


/**
 * Hide object when page is greater than the total pages.
 *
 * @param $which_object - Should the object be hide ?
 * @param page
 * @param totalPages
 */
utils.hideShowMore = function ($which_object, page, totalPages) {
    if (page > totalPages) {
        $which_object.hide();
    }
    else {
        $which_object.show();
    }
},

// Handle Ajax
/**
 * Send Ajax request
 *
 * @param url
 * @param type
 * @param data
 * @param dataType
 * @param success
 */
    utils.sendAjax = function ($whichBtn, url, type, data, dataType, success, beforeSend, afterSend) {
        beforeSend = $.isDefined(beforeSend) ? beforeSend : function () {
            return false;
        };
        afterSend = $.isDefined(afterSend) ? afterSend : function () {
            return false;
        };

        $.ajax({
            type: type,
            url: url,
            data: data,
            dataType: dataType,
            beforeSend: function () {
                // Show button process('disabled')
                if ($whichBtn) {
                    $whichBtn.addClass('btn-loading').addClass('disabled');
                }
                beforeSend();
            },
            success: function (data, status_code, jXhr) {
                success(data, status_code, jXhr);

                // Process redirect
                if ($.isDefined(data.redirect)) {
                    utils.redirect(data.redirect);
                }
            }
        }).done(function () {
            afterSend();

            if ($whichBtn) {
                $whichBtn.removeClass('btn-loading').removeClass('disabled');
            }
        });
    }


utils.animateUpdate = function ($whichObj) {
    if ($.isObject($whichObj)) {
        console.log($whichObj);
        setTimeout(function () {
            $whichObj.addClass('updating-item');
        }, 100);

        setTimeout(function () {
            $whichObj.removeClass('updating-item');
        }, 1600);
    }
}

utils.animateRemove = function ($whichObj,delay,callback) {
    if ($.isObject($whichObj)) {

        if ( ! $.isDefined(delay)) {
            delay = 900;
        }

        setTimeout(function () {
            $whichObj.addClass('removing-item');
        }, 100);

        setTimeout(function () {
            $whichObj.remove();
            callback();
        }, delay);

    }
}


// Below is an action helper for admin
utils.buckAction = function () {

    /**
     * Instantiate Buck Actions
     *
     * @param $which_form - the target object form
     * @param obj - the callback function when buck actions is changed
     */
    this.init = function ($which_form, obj) {
        var _self = this;
        _self.$form = $which_form;
        _self.obj = obj;

        _self.onEvent();
    };

    /**
     * On buck action is applied.
     *
     */
    this.onEvent = function () {
        var _self = this,
            $buckAction = _self.$form.find('.bulk_actions'),
            $button = $buckAction.find('.buck_action_btn');

        $button.on('click', function (e) {

            var cIds = _self.$form.tblist('getCb', true),
                $buckAction = $(this).closest('.bulk_actions'),
                $buckActionSelect = $buckAction.find('select').first(),
                param = "?",
                x,
                data = {},
                paramName = _self.$form.find('.cb-select').first().attr('name');

            // Automatically add the _token
            param += "_token=" + encodeURI(utils._token) + "&";

            for (x in cIds) {
                var theId = cIds[x];

                param += paramName + "[]=" + encodeURI(theId) + "&";
            }

            data.param = param;
            data.total = cIds.length;
            data.action = $buckActionSelect.val();
            data.action_input_name = $buckActionSelect.attr('name');

            // Run the object with the parameter of the data
            _self.obj(data);

            e.preventDefault();

        });
    };

}

utils.formatSize = function (n) {
    if (n > 1073741824) {
        return Math.round(n / 1073741824, 1) + " GB"
    }
    if (n > 1048576) {
        return Math.round(n / 1048576, 1) + " MB"
    }
    if (n > 1024) {
        return Math.round(n / 1024, 1) + " KB"
    }

    return n + " b"
};

utils.searchUser = function ($element) {
    this.$select = $element;
    this.endPoint = utils.adminUrl("/users/search-select");
    this.placeholder = 'Search for a distributor ..';

    /**
     * This would return an html for the select2 content
     *
     * @param user
     * @returns {string}
     */
    this.userFormatResult = function(user){
        var markup = "<table class='user'><tr>";
        markup += "<td class='user-info'><div class='user-title'>" + user.first_name + " " + user.last_name +"</div>";
        markup += "</td></tr></table>";
        return markup;
    }

    /**
     * When selected one of the result, we will generate the id and name of the user to be display
     * and put to hidden input box as the user for this discount
     *
     * @param user
     * @returns {string}
     */
    this.userFormatSelection = function(user) {
        return user.first_name  + " " + user.last_name;
    }

    /**
     * Run Selector
     *
     */
    this.init = function() {
        var _self = this;

        /**
         * This will search an user from the backend + user (PAP)
         *
         * @return null
         */
        _self.$select.select2({
            placeholder: _self.placeholder,
            minimumInputLength: 0,
            dropdownAutoWidth : true,
            allowClear: true,
            ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                url: _self.endPoint,
                dataType: 'json',
                data: function (term, page) {
                    var param = {
                        q: term, // search term
                        per_page: 25,
                        page: page,
                        _token: utils._token
                    };

                    // @note return format must be an json with a {total:20}{items:items_array
                    return param;
                },

                results: function (data, page) {
                    // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to alter remote JSON data
                    var more = (page * 25) < data.total;
                    return {results: data.users, more: more};
                }
            },
            initSelection: function(element, callback) {
                // the input tag has a value attribute preloaded that points to a preselected user's id
                // this function resolves that id attribute to an object that select2 can render
                // using its formatResult renderer - that way the movie name is shown preselected
                var id = $(element).val();

                if (id !== "")
                {
                    $.ajax(_self.endPoint, {
                        data: {
                            id: id,
                            method: "init-selection",
                            _token: utils._token
                        },
                        dataType: "json"
                    }).done(function(data) {
                        callback(data);
                    });
                }
            },
            formatResult: this.userFormatResult, // omitted for brevity, see the source of this page
            formatSelection: this.userFormatSelection,  // omitted for brevity, see the source of this page
            //dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
            escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
        });
    }
};

/**
 * Show a loader element inside a body.
 * Note!
 *
 * @param Element   $element
 *                  Note! $element should have a class "loader" and assume it is the wrapper
 *                         since it will append the loader init
 * @param bool      shouldDisplay
 * @return void
 */
utils.bodyLoader = function($element, shouldDisplay) {
    var loaderClass = '.loader-wrapper',
        html = '',
        $html;

    html += '<div class="loader-wrapper">';
    html += '<i class="fa fa-spin fa-spinner"></i>';
    html += '</div>';

    $html = $(html);

    // Remove element
    $element.find(loaderClass).remove();

    if (shouldDisplay) {

        $html.css({
            'width' :  $element.innerWidth(),
            'height' :  $element.innerHeight()
        });

        $html.appendTo($element);
    }
};

/**
 * Check if cookie is disabled.
 * see: http://stackoverflow.com/questions/8112634/jquery-detecting-cookies-enabled
 *
 * @returns {boolean}
 */
utils.isCookiesEnabled = function () {
    var cookieEnabled = (navigator.cookieEnabled) ? true : false;

    if (typeof navigator.cookieEnabled == "undefined" && !cookieEnabled)
    {
        document.cookie="testcookie";
        cookieEnabled = (document.cookie.indexOf("testcookie") != -1) ? true : false;
    }


    return (cookieEnabled);
};

utils.convertToSlug = function(Text) {
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
};
