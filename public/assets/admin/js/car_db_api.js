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
var carDBApi = function()
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
        make: '',
        model: '',
        year: '',
        trim: ''
    };

    this.default_options = {
        'inputForm':    '#cardbapi-form',
        'inputMake':    '#input_make',
        'inputModel':   '#input_model',
        'inputYear':    '#input_year',
        'inputTrim':    '#input_trim',
        'apiEndPoint':  '/car-db-api',
        'loadingText':  'Loading item ...',

        /**
         * When year, make, model and trim has all been set, js api will
         * request the id of for the select combination (i.e year ..) and
         * return a data of car model. Please console.log(data) so you can
         * see its returned value
         *
         * @param data
         * @returns {boolean}|{Void}
         */
        'onSuccess': function(data) {
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
        _self.$inputMake        = $(_self.options.inputMake);
        _self.$inputModel       = $(_self.options.inputModel);
        _self.$inputYear        = $(_self.options.inputYear);
        _self.$inputTrim        = $(_self.options.inputTrim);

        // Initialize selector listener
        _self._initMake();
        _self._initModel();
        _self._initYear();
        _self._initTrim();

        // Updat the first input
        _self._updateMake();
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
                var html;

                for (var i in data.results)
                {
                    var dataResult = data.results[i];
                    html += '<option value="'+dataResult.key+'">'+dataResult.value+'</option>';
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
    this._updateMake = function()
    {
        var _self = this,
            data = {};

        data.apiMethod  = 'getMakes';

        _self._beforeRequest = function() {
            _self._loadSelect(_self.$inputMake,true);
            _self._loadSelect(_self.$inputModel,true);
            _self._loadSelect(_self.$inputYear,true);
            _self._loadSelect(_self.$inputTrim,true);
        };
        _self._afterRequest = function() {
            _self._loadSelect(_self.$inputMake,false);
            _self.options.onProgress(_self.$inputMake);

            // Trigger next option when default value is set
            if (_self.initValue.make != '' && _self.isOnLoad) {
                _self.$inputMake.val(_self.initValue.make);
                _self._updateModel();
            }
        };

        _self._requestOptions(_self.$inputMake,data);
    };

    /**
     * Initialize the make select input on change
     *
     * @private
     * @return {Void}
     */
    this._initMake = function() {
        var _self = this;

        $('body').on('change',_self.options.inputMake,function()
        {
            if ($(this).val() != _self.SELECT_DEFAULT_EMPTY_VALUE)
            {
                _self._updateModel();
            }
        });
    };

    /**
     * Will Request Data options For Model select input
     *
     * @private
     * @return {Void}
     */
    this._updateModel = function() {
        var _self = this,
            data = {};

        data.apiMethod      = 'getModels';
        data.model_make_id  = _self.$inputMake.val();

        _self._beforeRequest = function() {
            _self._loadSelect(_self.$inputModel,true);
            _self._loadSelect(_self.$inputYear,true);
            _self._loadSelect(_self.$inputTrim,true);
        };
        _self._afterRequest = function() {
            _self._loadSelect(_self.$inputModel,false);
            _self.options.onProgress(_self.$inputModel);

            // Trigger next option when default value is set
            if (_self.initValue.model != '' && _self.isOnLoad) {
                console.log(_self.initValue.model);
                _self.$inputModel.val(_self.initValue.model);
                _self._updateYear();
            }
        };

        _self._requestOptions(_self.$inputModel,data);
    };

    /**
     * Initialize the model select input on change
     *
     * @private
     * @return {Void}
     */
    this._initModel = function() {
        var _self = this;

        $('body').on('change',_self.options.inputModel,function()
        {
            if ($(this).val() != _self.SELECT_DEFAULT_EMPTY_VALUE)
            {
                _self._updateYear();
            }
        });
    };

    /**
     * Will Request Data options For Year
     *
     * @private
     * @return {Void}
     */
    this._updateYear = function() {
        var _self = this,
            data = {};

        data.apiMethod = 'getYears';
        data.model_make_id  = _self.$inputMake.val();
        data.model_name     = _self.$inputModel.val();

        // Set Before and After
        _self._beforeRequest = function() {
            _self._loadSelect(_self.$inputYear,true);
            _self._loadSelect(_self.$inputTrim,true);
        };
        _self._afterRequest = function() {
            _self._loadSelect(_self.$inputYear,false);
            _self.options.onProgress(_self.$inputYear);

            // Trigger next option when default value is set
            if (_self.initValue.year != '' && _self.isOnLoad) {
                _self.$inputYear.val(_self.initValue.year);
                _self._updateTrim();
            }
        };

        _self._requestOptions(_self.$inputYear,data);
    };

    /**
     * Initialize the year select input on change
     *
     * @private
     * @return {Void}
     */
    this._initYear = function() {
        var _self = this;
        $('body').on('change',_self.options.inputYear,function()
        {
            if ($(this).val() != _self.SELECT_DEFAULT_EMPTY_VALUE)
            {
                _self._updateTrim();
            }
        });
    };

    /**
     * Will Request Data options For Trim select input
     *
     * @private
     * @return {Void}
     */
    this._updateTrim = function() {
        var _self = this,
            data = {};

        data.apiMethod      = 'getTrims';
        data.model_make_id  = _self.$inputMake.val();
        data.model_name     = _self.$inputModel.val();
        data.model_year     = _self.$inputYear.val();

        _self._beforeRequest = function() {
            _self._loadSelect(_self.$inputTrim,true);
        };
        _self._afterRequest = function() {
            _self._loadSelect(_self.$inputTrim,false);
            _self.options.onProgress(_self.$inputTrim);

            // Trigger next option when default value is set
            if (_self.initValue.trim != ''  && _self.isOnLoad) {
                _self.$inputTrim.val(_self.initValue.trim);
                _self._getMakeID();
            }
        };

        _self._requestOptions(_self.$inputTrim,data);
    };

    /**
     * Initialize the trim select input on change
     *
     * @private
     * @return {Void}
     */
    this._initTrim = function() {
        var _self = this;

        $('body').on('change',_self.options.inputTrim,function()
        {
            if ($(this).val() != _self.SELECT_DEFAULT_EMPTY_VALUE)
            {
                _self._getMakeID();
            }
        });
    };

    /**
     * Get the trim id from API if year, model, make and trim has been set.
     *
     * @private
     * @return {Void}
     */
    this._getMakeID = function() {
        var _self = this,
            requestData = {};

        // Flag On initiliazation onload when reach getMakeID method
        _self.isOnLoad = false;

        requestData.apiMethod = 'getMakeID';
        requestData.model_year = _self.$inputYear.val();
        requestData.model_make_id = _self.$inputMake.val();
        requestData.model_name = _self.$inputModel.val();
        requestData.model_trim = _self.$inputTrim.val();

        utils.sendAjax(false,_self.options.apiEndPoint,'GET',requestData,'JSON',function(data,status_code,jXhr) {
            // On Success
            if (data.status == 'success')
            {
                if (data.model_id)
                {
                    var model_data = requestData;
                    model_data.model_id = data.model_id;

                    _self.options.onSuccess(model_data);
                }
            }
        });
    };

}
