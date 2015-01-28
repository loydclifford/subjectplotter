/**
 * Location API
 * ======================
 * A simple implementation of local location API.
 *
 * @author: Rex Taylor
 * @version: 0.2.0
 * @changelogs:
 *      @ver: 0.2.0 - Initial beta released.
 */
var geolocationApi = function()
{
    // Define Constant
    this.SELECT_DEFAULT_EMPTY_VALUE     = '',
    this.PLACEHOLDER_CLASS              = '.select-placeholder',

    /**
     * An on load value of make, model, year and trim
     *
     * This is important if we want to load 4 default data.
     */
    this.initValue = {
        admin1: '',
        admin2: '',
        admin3: ''
    };

    this.default_options = {
        'inputForm':    '#cardbapi-form',
        'inputAdmin1':  '#input_admin1',
        'inputAdmin2':  '#input_admin2',
        'inputAdmin3':  '#input_admin3',
        'apiEndPoint':  '/car-db-api',
        'loadingText':  'Loading item ...',

        /**
         * When year, make, model and trim has all been set, js api will
         * request the id of for the select combination (i.e year ..) and
         * return a data of car model. Please console.log(data) so you can
         * see its returned value
         *
         * @returns {boolean}|{Void}
         */
        'onSuccess': function() {
            return false;
        },

        /**
         * Select form selection for year, make, model and trim has not
         * been completed or being in progress for selection
         *
         * @param {Object} $currentInput - The current Input the progress into
         * @returns {boolean}|{Void}
         */
        'onProgress': function($currentInput) {
            return false;
        }
    };

    /**
     * Call on initiation
     *
     * @param {Array} options_param
     */
    this.init = function(options_param) {
        var _self = this;

        _self.options = jQuery.extend({}, _self.default_options, options_param);

        // Flag On Load
        _self.isOnLoad = true;

        // Global Selectors
        _self.$form             = $(_self.options.inputForm);
        _self.$inputAdmin1        = $(_self.options.inputAdmin1);
        _self.$inputAdmin2       = $(_self.options.inputAdmin2);
        _self.$inputAdmin3        = $(_self.options.inputAdmin3);

        // Initialize selector listener
        _self._initAdmin1();
        _self._initAdmin2();
        _self._initAdmin3();

        // Updat the first input
        _self._updateAdmin1();
    };

    /**
     * Do remove options not including this.PLACEHOLDER_CLASS and remove if "doStart"
     * param is true, else remove "disabled" attribute
     *
     * @param {Object} $select - The option to process
     * @param {Boolean} doStart -
     *      - true: disable the $select and remove option not including this.PLACEHOLDER_CLASS
     *      - false: remove disable attribute in the $select
     * @private
     */
    this._loadSelect = function($select, doStart) {
        var _self = this;

        if (doStart) {
            $select.prop('disabled','disabled');
            $select.find('option')
                .not(_self.PLACEHOLDER_CLASS)
                .remove();
        } else {
            $select.removeAttr('disabled').prop('disabled',false);
        }
    };

    /**
     * This function will be called before "_requestOptions" method
     * will started
     *
     * @private
     */
    this._beforeRequest = function() {};

    /**
     * This function will be called when "_requestOptions" method
     * has ended
     *
     * @private
     */
    this._afterRequest = function() {};

    /**
     * This function request data to API end point
     *
     * @param {Object} $which_input - The select Input To process
     * @param {Array} requestData - The data to request Via Ajax
     * @private
     */
    this._requestOptions = function($which_input, requestData) {
        var _self = this,
            $placeHolder = $which_input.find(_self.PLACEHOLDER_CLASS),
            realSctPlaceholderText = $placeHolder.text();

        utils.sendAjax(false,_self.options.apiEndPoint,'GET',requestData,'JSON',function(data,status_code,jXhr) {
            // On Success
            if (data.status == 'success')
            {
                var html = '';
                for (var i in data.results)
                {
                    var item = data.results[i];
                    html += '<option value="'+item.key+'">'+item.value+'</option>';
                }

                $which_input.append(html);
            }
        },function() {
            // On Start
            // Add loading Text
            $placeHolder.text(_self.options.loadingText);
            $which_input.find('option').not(_self.PLACEHOLDER_CLASS).remove();

            _self._beforeRequest();
        }, function() {
            // On End
            $placeHolder.text(realSctPlaceholderText);

            _self._afterRequest();
        });
    };

    /**
     * Will Request Data options For Make select input
     *
     * @private
     * @return {Void}
     */
    this._updateAdmin1 = function()
    {
        var _self = this,
            data = {};

        data.apiMethod  = 'getAdmin1';

        _self._beforeRequest = function() {
            _self._loadSelect(_self.$inputAdmin1,true);
            _self._loadSelect(_self.$inputAdmin2,true);
            _self._loadSelect(_self.$inputAdmin3,true);
        };
        _self._afterRequest = function() {
            _self._loadSelect(_self.$inputAdmin1,false);
            _self.options.onProgress(_self.$inputAdmin1);
            // Trigger next option when default value is set
            if (_self.initValue.admin1 != '' && _self.isOnLoad) {
                _self.$inputAdmin1.val(_self.initValue.admin1);
                _self._updateAdmin2();
            }
        };

        _self._requestOptions(_self.$inputAdmin1,data);
    };

    /**
     * Initialize the make select input on change
     *
     * @private
     * @return {Void}
     */
    this._initAdmin1 = function() {
        var _self = this;

        $('body').on('change',_self.options.inputAdmin1,function()
        {
            if ($(this).val() != _self.SELECT_DEFAULT_EMPTY_VALUE)
            {
                _self._updateAdmin2();
            }
        });
    };

    /**
     * Will Request Data options For Model select input
     *
     * @private
     * @return {Void}
     */
    this._updateAdmin2 = function() {
        var _self = this,
            data = {};

        data.apiMethod      = 'getAdmin2';
        data.admin1_code  = _self.$inputAdmin1.val();

        _self._beforeRequest = function() {
            _self._loadSelect(_self.$inputAdmin2,true);
            _self._loadSelect(_self.$inputAdmin3,true);
        };
        _self._afterRequest = function() {
            _self._loadSelect(_self.$inputAdmin2,false);
            _self.options.onProgress(_self.$inputAdmin2);

            // Trigger next option when default value is set
            if (_self.initValue.admin2 != '' && _self.isOnLoad) {
                console.log(_self.initValue.admin2);
                _self.$inputAdmin2.val(_self.initValue.admin2);
                _self._updateAdmin3();
            }
        };

        _self._requestOptions(_self.$inputAdmin2,data);
    };

    /**
     * Initialize the model select input on change
     *
     * @private
     * @return {Void}
     */
    this._initAdmin2 = function() {
        var _self = this;

        $('body').on('change',_self.options.inputAdmin2,function()
        {
            if ($(this).val() != _self.SELECT_DEFAULT_EMPTY_VALUE)
            {
                _self._updateAdmin3();
            }
        });
    };

    /**
     * Will Request Data options For Year
     *
     * @private
     * @return {Void}
     */
    this._updateAdmin3 = function() {
        var _self = this,
            data = {};

        data.apiMethod = 'getAdmin3';
        data.admin1_code  = _self.$inputAdmin1.val();
        data.admin2_code     = _self.$inputAdmin2.val();

        // Set Before and After
        _self._beforeRequest = function() {
            _self._loadSelect(_self.$inputAdmin3,true);
        };
        _self._afterRequest = function() {
            _self._loadSelect(_self.$inputAdmin3,false);
            _self.options.onProgress(_self.$inputAdmin3);

            // Trigger next option when default value is set
            if (_self.initValue.admin3 != '' && _self.isOnLoad) {
                _self.$inputAdmin3.val(_self.initValue.admin3);
            }
        };

        _self._requestOptions(_self.$inputAdmin3,data);
    };

    /**
     * Initialize the year select input on change
     *
     * @private
     * @return {Void}
     */
    this._initAdmin3 = function() {
        var _self = this;
        $('body').on('change',_self.options.inputAdmin3,function()
        {
            if ($(this).val() != _self.SELECT_DEFAULT_EMPTY_VALUE)
            {
                _self._onSuccess();
            }
        });
    };

    /**
     * Get the trim id from API if year, model, make and trim has been set.
     *
     * @private
     * @return {Void}
     */
    this._onSuccess = function() {
        this.options.onSuccess();
    };

}
