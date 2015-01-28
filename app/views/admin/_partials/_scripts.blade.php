
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

</script>