'use strict';

var utils = typeof utils === 'undefined' ? [] : utils;

utils.selectMedia = function() {
    this.$modal = $('#select-media-modal');
    this.$cancelBtn = '';
    this.$selectBtn  = '';
    this.$selectedItems  = '';
    this.$showOnlySelected  = '';
    this.$button  = '';
    this.$modalTitle  = '';

    this.options = {
        button: '#select-media-modal',
        onSelect: function(mediaData, selectMedia) {
            return false;
        },
        onCancel: function(selectMedia) {
            return false;
        },
        multipleSelection: false,
        selectedItems: '',
        selectBtnText: 'Select Media',
        cancelBtnText: 'Cancel',
        modalTitleText: 'Select Media',
    };

    this.init = function(options) {
        this.options = jQuery.extend({}, this.options, options);

        // set elements
        this.$modal.attr('id', 'select-media-'+this._uniqueId());
        this.$modal.prependTo('body');

        // set btn elements
        this.$button = $(this.options.button);
        this.$cancelBtn = this.$modal.find('.js-select-cancel');
        this.$showOnlySelected = this.$modal.find('#show_only_selected');
        this.$selectBtn = this.$modal.find('.js-select-media');

        this.$modalTitle = this.$modal.find('.modal-title');
        this.$selectedItems = this.$modal.find('input[name="selected_items"]');

        this._configureModal();
        this._registerListener();
    };

    this._uniqueId = function() {
        return Math.floor(Math.random() * 26) + Date.now();
    };

    this._configureModal = function() {
        this.$selectedItems.val(this.options.selectedItems);
        this.$cancelBtn.val(this.options.cancelBtnText);
        this.$selectBtn.val(this.options.selectBtnText);
        this.$modalTitle.val(this.options.modalTitleText);

        var ids = this.getSelectedItemsArr();

        if (ids.length) {
            this.$showOnlySelected.prop('checked', true);
        } else {
            this.$showOnlySelected.prop('checked', false);
        }

        this.refreshTblist();
    };

    this._registerListener = function() {
        var _self = this;
        this.$button.on('click', function() {
            _self.$modal.modal('show');
            _self.refreshTblist();
        });

        this.$selectBtn.on('click', function() {
            // validate media
            var ids = _self.getSelectedItemsArr();
            if ( ! ids.length){
                bootbox.alert(utils.lang.no_selected_media);
                return ;
            }

            var idsEncoded = encodeURIComponent(ids.join(','));
            var urlEndPoint = utils.adminUrl('/media/get-media-data?media_ids='+idsEncoded);
            $.getJSON(urlEndPoint, function(data) {
                if (data.status == utils.result.RESULT_SUCCESS) {
                    _self.options.onSelect(data.media_data, _self);
                } else {
                    bootbox.alert(utils.lang.internal_error);
                }
            });
        });

        this.$cancelBtn.on('click', function() {
            // validate media
            _self.$selectedItems.val(_self.options.selectedItems);
            // trigger tblist refresh
            _self.refreshTblist();
            _self.options.onCancel(_self);
        });

        this.$modal.delegate('input[name="medias_id"]', 'click', function() {
            var $this = $(this);

            _self.$selectedItems.val($this.val());
        });
    };

    this.getSelectedItemsArr = function() {
        return this.$selectedItems.val().split(',');
    };

    this.setSelectedItemsArr = function() {
        var checkedVals = $('input[name="medias_id"]:checked').map(function() {
            return this.value;
        }).get();

        return this.$selectedItems.val(checkedVals.join(','));
    };

    this.refreshTblist = function() {
        $('[data-target="#tab-media-library"]').trigger('click');
    };
};


jQuery(function() {
    /*
     * Tblist Global Configuration
     * ---------------------------------------------
     !**/
    var $tblist = $("#media_select_tblist_form");
    $tblist.tblist({
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

    // refresh on click in media library tab
    $('body').delegate('[data-target="#tab-media-library"]', 'click', function() {
        $tblist.tblist('refresh');
    });

});