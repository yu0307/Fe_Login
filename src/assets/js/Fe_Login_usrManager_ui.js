var usrManagementTarget = '';
$(document).ready(function () {
    $(document).on("usr_manageRefreshList", '#usr_management_area', function (event) {
        LoadList();
    });
});

function LoadList() {
    $('.user_list').fadeOut(300, 'linear', function () {
        $('.user_list').html('<div class="fa-3x text-center"><i class="fas fa-circle-notch fa-spin"></i><div><h4>Loading ...</h4></div></div >');
        $('.user_list').fadeIn(300, 'linear', function () {
            $.ajax({
                type: 'POST',
                url: usrManagementTarget + '/load',
                dataType: 'json',
                // data: data,
                complete: function (jqXHR, status) {
                    var data = jqXHR.responseJSON;
                    $('.user_list').fadeOut(300, 'linear', function () {
                        $('.user_list').empty();
                        if (data !== undefined && data.length > 0) {
                            $.each(data, function (key, elm) {
                                $('.user_list').append(
                                    '<div class="users" UID="' + elm.id + '">' +
                                    '<div class="user_img" > <img class="user_prof_pics img-circle" src="' + elm.img + '"></div>' +
                                    '<div class="user_names">' + elm.name + '</div>' +
                                    '</div >');
                            });
                        } else {
                            $('.user_list').html('<p>There are no users...</p>');
                        }
                        $('.user_list').fadeIn(300);
                    });

                }
            });
        });
    });
}

function CreateUser(ex_data = {}, after_call = null) {
    var data = {};
    $.each($('.form-control').serializeArray(), function (idx, elm) {
        data[elm['name']] = elm['value'];
    });
    data = $.extend(data, ex_data);
    $.ajax({
        type: 'POST',
        url: usrManagementTarget,
        dataType: 'json',
        data: data,
        complete: function (jqXHR, status) {
            var data = jqXHR.responseJSON;
            if (data.message !== undefined) {
                message = data.message;
                message += jQuery.map(data.errors, function (n, i) {
                    return ('<div class="error">' + i + ':' + n + '</div>');
                }).join("");
                if (typeof (after_call) === 'function') {
                    after_call(data, message);
                    $('#usr_management_area').trigger('usr_manageRefreshList');
                }
            }
        }
    });
}