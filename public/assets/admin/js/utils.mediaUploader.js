'use strict';

var utils = typeof utils === 'undefined' ? [] : utils;

// Car Images Upload(Plupload)
// ---------------------------
utils.mediaUploader = function() {

    this.init = function() {
        var $uplupload = new utils.plupload();
        $uplupload.$fileList    = $('#pupload-filelist');
        $uplupload.dropArea     = 'pupload-drop-area';
        $uplupload.browseBtn    = 'pupload-browse-btn';
        $uplupload.fileItem     = '.file-item';
        $uplupload.url          = utils.adminUrl('/media/upload');
        $uplupload.dismissBtn   = '.dismiss';
        $uplupload.cancelBtn    = '.cancel-upload';
        $uplupload.mimeTypes    =  [{ title: "Image files", extensions: utils.config.fileExtensions }];
        $uplupload.multiPartParams = { _token: utils._token };

        $uplupload.formatAddResult = function(i, file) {

            var markup = '<div id="file-' + file.id + '" class="file-item">' +
                '<div class="file-actions">' +
                '<span class="upload-percentage">(0 %)</span>' +
                '</div>' +
                '<div class="filename">' +
                '<span class="title">' + file.name + '</span>' +
                '<br />' +
                '<strong>' + utils.formatSize(file.size) + '</strong>' +
                '</div>' +
                '</div>';

            this.$fileList.append(markup);

            // We need to reposition silver, flash and html 5 shim
            this.refreshInstance();
        };
        $uplupload.onProgress = function(up, file) {
            this.$fileList
                .find('#file-' + file.id + ' .upload-percentage')
                .html('(' + file.percent + ' %)');
        };

        $uplupload.onError = function(up, file, data) {
            var markup = '<div id="file-' + file.id + '"class="col-sm-3 product-image-item product-image-failed">' +
                '<div class="product-image-wrapper">' +
                '<i class="fa fa-warning"></i>' +
                '<p class="text-ellipsis">“' + file.name + '”</p>' +
                '<p class="text-ellipsis">' + data.message + '</p>' +
                '<p><a href="#" class="dismiss">Remove</a></p>' +
                '</div>' +
                '</div>';

            this.$fileList.find('#file-' + file.id).replaceWith(markup);
        };

        $uplupload.onSuccess = function(up, file, data) {
            // If image path is returned.
            $('#' + file.id + ' span').html(data.message).addClass(data.type);

            if (data.status == utils.result.RESULT_FAILURE)
            {
                var markup = '<div id="file-'+file.id+'" class="file-item">' +
                    '<div class="file-actions">' +
                    '<a class="dismiss" target="_blank" href="">dismiss</a>' +
                    '</div>' +
                    '<strong>“'+file.name+'” '+data.message+'</strong>' +
                    ' </div>';

                this.$fileList.find('#file-'+file.id).replaceWith(markup);
            }
            else
            {
                var imgMarkup = '';

                // If image path is returned.
                if ($.isDefined(data.thumb_path))
                {
                    imgMarkup = '<img class="thumbnail" alt="" src="'+data.thumb_path+'">';
                }

                var markup = '<div id="file-'+file.id+'" class="file-item">' +
                    imgMarkup +
                    '<div class="file-actions">' +
                    '<a href="'+data.edit_url+'" class="edit" target="_blank">Edit</a>' +
                    '</div>' +
                    '<div class="filename">' +
                    '<span class="title">'+data.file_client_name+'</span>' +
                    '<br />' +
                    '<strong>' + utils.formatSize(data.file_size) + '</strong>' +
                    '</div>' +
                    '</div>';

                this.$fileList.find('#file-'+file.id).replaceWith(markup);
            }
        };


        $uplupload.onDrop = function () {
            var $body = $('body');
            var $dragArea = $("#pupload-drop-area");
            var $puploadui = $("#pupload-ui");
            var $clonedDragArea = $dragArea.clone();

            function onOver() {
                $dragArea
                    .addClass('drag-over')
                    .css({position:'fixed'});

                $puploadui.prepend($clonedDragArea);
                $dragArea.prependTo('body');
            }

            function onEnd() {
                $dragArea
                    .removeClass('drag-over')
                    .css({position:'relative'});

                $clonedDragArea.remove();
                $dragArea.prependTo($puploadui);
            }

            $("body").delegate('.row-offcanvas','dragover', function (event) {
                onOver();
            });

            $("body").delegate('.drag-over','dragleave', function (event) {
                onEnd();
            });

            $("body").delegate('#pupload-drop-area','drop', function (event) {
                onEnd();
            });
        };

        $uplupload.init();
    }
};