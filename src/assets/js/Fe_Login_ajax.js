$(document).ready(function () {
    $("#Fe_login-block #info_Section").hide();
    $("#Fe_login-block form").submit(function (e) {
        e.preventDefault();
        var submitButton = $("#Fe_login-block form input[type=submit]");
        $("#Fe_login-block #info_Section:visible").slideUp(100);
        $.ajax({
            type: 'POST',
            url: $(this).prop('action'),
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function () {
                submitButton.prop('disabled', 'disabled');
            },
            complete: function (jqXHR, status) {
                var data = jqXHR.responseJSON;
                var html = data.message;
                if ($.type(data.message) != 'string') {
                    html = "";
                    $.each(data.message, function (key, value) {
                        html += "<h5>" + key + "</h5>";
                        if ($.type(value) != 'string') {
                            $(value).each(function (idx, msg) {
                                html += "<div class='sub_error_itm'>" + msg + "</div>";
                            });
                        } else {
                            html += "<div class='sub_error_itm'>" + value + "</div>";
                        }

                    });
                } else {

                }
                $("#Fe_login-block #info_Section >div").html('<div class="alert alert-' + data.status + ' info general">' + html + "</div>");
                $("#Fe_login-block #info_Section").slideDown(300, 'linear', function () {
                    if (data.status == 'success') {
                        $("#Fe_login-block #info_Section div.alert:last").append('<div>Redirecting in 2 seconds...</div>');
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }
                });
            }
        }).done(function (data) {
            submitButton.prop('disabled', false);
        });
        return false;
    });
    $('#Fe_login_modal_window').on('hidden.bs.modal', function (e) {
        $('#Fe_login-block .Fe_ctrl_windows').hide();
        $('#Fe_login-block #Fe_Login_container').show();
    })
});