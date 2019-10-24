$(document).ready(function () {
    $('#usrSecurityArea .saveChange').click(function (e) {
        e.preventDefault();
        var l = Ladda.create(this);
        var postdata = {};
        $.each($('#usrSecurityArea .form-control').serializeArray(), function (idx, elm) {
            postdata[elm['name']] = elm['value'];
        });
        postdata.metainfo = {};
        $.each($('#usrSecurityAreaMetas .form-control').serializeArray(), function (idx, elm) {
            postdata.metainfo[elm['name']] = elm['value'];
        });
        $.ajax({
            'type': 'POST',
            'dataType': 'json',
            'url': $('#usrSecurityArea').attr('data-target'),
            'data': postdata,
            'complete': function (jqXHR, status) {
                var data = jqXHR.responseJSON;
                if (data.message !== undefined) {
                    message = data.message;
                    message += jQuery.map(data.errors, function (n, i) {
                        return ('<div class="error c-red">' + i + ':' + n + '</div>');
                    }).join("");
                    Notify(message, (data.status !== undefined ? data.status : 'info'));
                }
                $('#usrSecurityArea .form-control').val("").trigger('change');
                l.stop();
            }
        });
    });
});