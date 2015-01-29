
<script>

    "use strict";

    var utils = {};

    utils.baseUrl = function(url) {
        return '{{ url() }}' + url;
    };

    utils.adminUrl = function(url) {
       return '{{ admin_url() }}' + url;
    };

    utils.assetUrl = function(url) {
        return '{{ asset_url() }}' + url;
    };

    utils._token          = "{{ csrf_token() }}";


    utils.serverRequestUri = '{{ isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : NULL }}';

    utils.curUrl          = "{{ URL::current() }}";
    utils.lang            = {{ json_encode(lang('js')) }};
    utils.isGuest         = {{ torf(user_guest()) }};
    utils.isLoggedIn      = {{ torf(user_check()) }};
    utils._token          = "{{ csrf_token() }}";

    // Load Configurations
    utils.config = {
    };

    utils.fileErrors = {
        HTTP_ERROR: '{{ lang('files.http_error') }}',
        FILE_EXTENSION_ERROR: '{{ lang('files.file_extension_error') }}',
    };

    utils.result = {
        RESULT_SUCCESS:         '{{ RESULT_SUCCESS  }}',
        RESULT_FAILURE:         '{{ RESULT_FAILURE  }}',
        RESULT_NOT_LOG_IN:      '{{ RESULT_NOT_LOG_IN  }}',
        RESULT_INVALID_TOKEN:   '{{ RESULT_INVALID_TOKEN  }}'
    };
</script>