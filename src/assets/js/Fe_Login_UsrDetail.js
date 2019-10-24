$(document).ready(function () {
    $('#User_Details .saveChange').click(function (e) {
        e.preventDefault();
        var l = Ladda.create(this);
        var postdata = {};
        $.each($('#usrDetail .form-control').serializeArray(), function (idx, elm) {
            postdata[elm['name']] = elm['value'];
        });
        postdata.metainfo = {};
        $.each($('#usrDetailMetas .form-control').serializeArray(), function (idx, elm) {
            postdata.metainfo[elm['name']] = elm['value'];
        });
        $.ajax({
            'type': 'POST',
            'dataType': 'json',
            'url': $('#usrDetailArea').attr('data-target'),
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
                l.stop();
            }
        });
    });
    $('#Profile_Panel .usrProfile.editable').append('<div class="ctrls"><i class="fa fa-pencil-square-o">Edit</i></div>');
});