/**
 * A simple Helper for PLupload plugin
 *
 * Method and Binding method used for this helper
 *  Uploader
 *  refresh
 *  init
 *  removeFile
 *  bind:
 *      FilesAdded
 *      UploadProgress
 *      FileUploaded
 *      Error
 *
 * see: http://www.plupload.com/docs/
 *
 * @author: Rex Taylor <rex@lightmedia.com.au>
 * @version: 2.0.2
 */

'use strict';

var utils = typeof utils === 'undefined' ? [] : utils;

utils.plupload = function() {

    /**
     * Plupload file item wrapper
     *
     * @type {*|jQuery|HTMLElement}
     */
    this.$fileList = $('#pupload-filelist');

    /**
     * ID without hash, on the droparea or upload button
     *
     * @type {string}
     */
    this.dropArea = 'pupload-drop-area';

    /**
     * ID without hash, on the droparea or upload button
     *
     * @type {string}
     */
    this.browseBtn = 'pupload-drop-area';

    /**
     * The class with dot "." without quotes of file items
     *
     * @type {string}
     */
    this.fileItem = '.product-image-item';

    /**
     * The target url that the file will be posted into
     *
     * @type {string}
     */
    this.url = '';

    /**
     * The class with dot "." without quotes of file items remove button
     * Note! This is only available when file is failed to upload
     *
     * @type {string}
     */
    this.dismissBtn = '.dismiss';

    /**
     * The class with dot "." without quotes of file items cancel upload button
     * Note! This is only available when file is uploading or in progress for upload
     *
     * @type {string}
     */
    this.cancelBtn = '.cancel';

    /**
     * Add a nice effect on remove.
     *
     * @type {integer}
     */
    this.removeDelay = 1400;

    /**
     * Add A nice File Item remove (.fadeOut())
     *
     * @param $productItem
     */
    this.removeElement = function ($productItem) {
        var _self = this;

        $productItem.css('opacity','.3');
        setTimeout(function(){
            $productItem.remove();

            // Reset layout
            _self.refreshInstance();
        }, _self.removeDelay);
    };

    /**
     * Mime types required by PLuploads plugin
     * see: http://www.plupload.com/docs/Options#filters.mime_types
     *
     * @type {{title: string, extensions: string}[]}
     */
    this.mimeTypes =  [
        { title: "Image files", extensions: "jpg,gif,png,jpeg" },
        { title: "Zip files", extensions: "zip" },
        { title: "Video files", extensions: "wav,mpeg,mpg,mpe,mov,avi,3gp,mp4" },
        { title: "Mp3 files", extensions: "mp3" },
        { title: "Docs files", extensions: "pdf,docx,doc,xls,ppt" }
        // { title : "Text files", extensions : "css,jsc,php,htm,html" }
        // { title : "Other files", extensions : "exe" }
    ];

    /**
     * Data parameter when post request is made
     * see: http://www.plupload.com/docs/Options#multipart_params
     *
     * @type {{_token: (*|param._token|.data._token)}}
     */
    this.multiPartParams = {
        _token: utils._token
    };

    /**
     * An action made when a file is added for quee
     * see: http://www.plupload.com/docs/Uploader#FilesAdded-event
     *
     * @param i
     * @param file - File info from PLupload
     */
    this.formatAddResult = function(i, file) {
        var _self = this;

        var markup =  '<div id="file-' + file.id + '" class="file-item">' +
            '<div class="file-actions">' +
            '<span class="upload-percentage">(0 %)</span>' +
            '</div>' +
            '<div class="filename">' +
            '<span class="title">' + file.name + '</span>' +
            '<br />' +
            '<strong>' + cms.formatSize(file.size) + '</strong>' +
            '</div>' +
            '</div>';

        _self.$fileList.append(markup);
        _self.refreshInstance();
    };

    /**
     * An action when a file new progress status is pushed
     * see: http://www.plupload.com/docs/Uploader#UploadProgress-event
     *
     * @param up
     * @param file - File info from PLupload
     */
    this.onProgress = function(up, file) {
        var _self = this;
        _self.$fileList.find('#file-' + file.id + ' .upload-percentage')
            .html('(' + file.percent + ' %)');
    };

    /**
     * When Server process the file, it return a status key with
     * a value of "error|success", if error: it will be fetched here
     *
     * Do a necessary action when error is returned.
     *
     * @param up
     * @param file - File info from PLupload
     * @param data - Server Response
     */
    this.onError = function(up, file, data) {
        var _self = this;
        var markup = '<div id="file-' + file.id + '" class="file-item">' +
            '<div class="file-actions">' +
            '<a class="dismiss" target="_blank" href="">dismiss</a>' +
            '</div>' +
            '<strong>“' + file.name + '” ' + data.message + '</strong>' +
            ' </div>';

        _self.$fileList.find('#file-' + file.id).replaceWith(markup);
    };

    /**
     * When Server process the file, it return a status key with
     * a value of "error|success", if success: it will be fetched here
     *
     * Do a necessary action when success is returned.
     *
     * @param up
     * @param file - File info from PLupload
     * @param data - Server Response
     */
    this.onSuccess = function(up, file, data) {
        var _self = this,
            imgMarkup = '';

        // If image path is returned.
        if ($.isDefined(data.thumb_path)) {
            imgMarkup = '<img class="thumbnail" alt="" src="' + data.thumb_path + '">';
        }

        var markup = '<div id="file-' + file.id + '" class="file-item">' +
            imgMarkup +
            '<div class="file-actions">' +
            '<a href="' + data.edit_url + '" class="edit" target="_blank">Edit</a>' +
            '</div>' +
            '<div class="filename">' +
            '<span class="title">' + data.file_client_name + '</span>' +
            '<br />' +
            '<strong>' + cms.formatSize(data.file_size) + '</strong>' +
            '</div>' +
            '</div>';

        _self.$fileList.find('#file-' + file.id).replaceWith(markup);
    }

    /**
     * Reserved for Plupload instance
     *
     * @type {object}
     */
    this.$_puInstance = '';

    /**
     * Reserved for Plupload add quee error dialog
     *
     * @type {object} | bootbox
     */
    this.$_errorDialog = '';

    /**
     * Initialize Uploader {Plupload Helper}
     *
     * @return {Void}
     */
    this.init = function () {
        var _self = this;

        _self.onDrop();
        _self._setInstance();

        // pupload binding
        _self._puInit();
        _self._puFilesAdded();
        _self._puUploadProgress();
        _self._puFileUploaded();
        _self._onAddError();

        // Added file action
        _self._dismiss();
        _self._cancelFile();
    };

    /**
     * Listen to remove button failed item, and remove the file items
     *
     * @private
     */
    this._dismiss = function () {
        var _self = this;

        _self.$fileList.delegate(_self.dismissBtn, 'click', function (e) {
            var $this = $(this),
                $productItem = $this.closest(_self.fileItem);

            // Remove ELment with a nice face in
            _self.removeElement($productItem);

            e.preventDefault();
        });
    };

    /**
     * Listen to cancel button item on file upload progress, and abort upload and
     * remove the file items
     *
     * @private
     */
    this._cancelFile = function () {
        var _self = this;

        _self.$fileList.delegate(_self.cancelBtn, 'click', function (e) {
            var $this = $(this),
                $productItem = $this.closest(_self.fileItem);

            // get the file id to remove
            var idStr = $productItem.attr('id');
            var id = idStr.replace(/^file\-/, '');

            // remove file
            _self.$_puInstance.removeFile(id);

            // Remove ELment with a nice action
            _self.removeElement($productItem);

            e.preventDefault();
        });
    };

    /**
     * When a browser detect a drop on the dropArea, then add a class "drop-over"
     * so it will be more user friendly.
     *
     * @private
     */
    this.onDrop = function () {
        var $body = $('body');
        $body.delegate('#' + this.dropArea, 'dragover', function (event) {
            $(this).addClass('drop-over');
        });

        $body.delegate('#' + this.dropArea, 'dragleave', function (event) {
            $(this).removeClass('drop-over');
        });

        $body.delegate('#' + this.dropArea, 'drop', function (event) {
            $(this).removeClass('drop-over');
        });
    };

    /**
     * We need to set the $_puInstance property to the instance of Pluploader
     * constructor.
     *
     * @private
     */
    this._setInstance = function () {
        var _self = this;

        _self.$_puInstance = new plupload.Uploader({
            // See options documentation
            // http://www.plupload.com/docs/Options#required-options
            browse_button: _self.browseBtn,
            drop_element: document.getElementById(_self.dropArea),
            url: _self.url,

            filters: {
                mime_types: _self.mimeTypes,

                // Default: 0 (unlimited)
                max_file_size: 0,

                // Default: false
                prevent_duplicates: false
            },

            // Control the Request
            multipart_params: _self.multiPartParams,

            // max_retries: 0,
            multi_selection: true,

            runtimes: "html5,flash,silverlight,html4",
        });
    };

    /**
     * Reposition flash/silverlight shims on the page.
     * see: http://www.plupload.com/docs/Uploader#refresh--method
     *
     * @public
     */
    this.refreshInstance = function () {
        var _self = this;

        _self.$_puInstance.refresh();
    };

    /**
     * Initialized the set instance
     *
     * @private
     */
    this._puInit = function () {
        var _self = this;

        /*
        _self.$_puInstance.bind('Init', function(up, params) {
            _self.$fileList.html("<div>Upload engine: " + params.runtime + "</div>");
        });
        console.log(_self.$_puInstance);
        */
        _self.$_puInstance.init();
    },

    /**
     * We can bind when file(s) is dropped or selected via FilesAdded method
     * in Plupload
     *
     * @private
     */
    this._puFilesAdded = function () {
        var _self = this;

        _self.$_puInstance.bind('FilesAdded', function (up, files) {

            // Show Markup On Drop or Select
            $.each(files, function (i, file) {
                _self.formatAddResult(i, file);
            });

            // Start automatically on upload
            _self.$_puInstance.start();
        });
    };

    /**
     * We can bind when file(s) is progressing via UploadProgress method
     * in Plupload
     *
     * @private
     */
    this._puUploadProgress = function () {
        var _self = this;

        _self.$_puInstance.bind('UploadProgress', function (up, file) {
            _self.onProgress(up, file);
        });
    };

    /**
     * We can bind when file(s) is uploaded to the server via FileUploaded method
     * in Plupload
     *
     * @private
     */
    this._puFileUploaded = function () {
        var _self = this;

        _self.$_puInstance.bind('FileUploaded', function (up, file, info) {
            var data = jQuery.parseJSON(info.response);

            if (data.status == 'error') {
                _self.onError(up, file, data);
            } else {
                _self.onSuccess(up, file, data);
            }
        });
    };

    /**
     * We can bind when file(s) is added to the quee is error via Error
     * in Plupload
     *
     * @private
     */
    this._onAddError = function () {
        var _self = this;

        _self.$_puInstance.bind('Error', function (up, file) {

            if (typeof _self.$_errorDialog.modal !== 'undefined') {
                _self.$_errorDialog.modal('hide');
            }

            if (file.code == plupload.FILE_EXTENSION_ERROR) {
                _self.$_errorDialog = bootbox.alert(utils.fileErrors.FILE_EXTENSION_ERROR);
            } else if (file.code == plupload.HTTP_ERROR) {
                _self.$_errorDialog = bootbox.alert(utils.fileErrors.HTTP_ERROR);
            }
        });
    };

}