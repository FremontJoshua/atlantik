function ajax(url, params, $target, method) {
    if ($target === undefined) {
        $target = $('#content');
    }
    if (params === undefined) {
        params = [];
    }
    if (method === undefined) {
        method = 'GET';
    }
    $target.html('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.ajax({
        url: url,
        data: params,
        method:method,
        success: function (html) {
            $target.html(html);
            if ($('#refresh') !== undefined) {
                $('#refresh').click(function () {
                    ajax(url, params, $target,method);
                });
            }
        }
    });
}