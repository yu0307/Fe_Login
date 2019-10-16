var usrManagementTarget = '';
$(document).ready(function () {
    $(document).on("usr_manageRefreshList", '#usr_management_area', function (event) {
        LoadList();
    });
    usrManagementTarget = $('#usr_management_area').attr('actionTarget');
});

function LoadList() {
    $('.user_list').fadeOut(300, 'linear', function () {
        $('.user_list').html('<div class="fa-3x text-center"><i class="fas fa-circle-notch fa-spin p-0 fa fa-circle-o-notch fa-fw"></i><div><h4 class="t-center text-center">Loading ...</h4></div></div >');
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
                                    '<div class="usr_remove text-center t-center"><i class="animated fadeOutDown far fa fa-times-circle fa-times-circle-o c-red fa-2x p-0"></i></div>' +
                                    '<div class="user_img" > <img class="user_prof_pics img-circle" src="' + elm.img + '"></div>' +
                                    '<div class="user_names t-center text-center">' + elm.name + '</div>' +
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

function SaveUser(ex_data = {}, after_call = null) {
    var data = {};
    $.each($('#usrBasic .form-control').serializeArray(), function (idx, elm) {
        data[elm['name']] = elm['value'];
    });
    data.metainfo = {};
    $.each($('#Additional_Info .form-control').serializeArray(), function (idx, elm) {
        data.metainfo[elm['name']] = elm['value'];
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
                    return ('<div class="error c-red">' + i + ':' + n + '</div>');
                }).join("");
                if (typeof (after_call) === 'function') {
                    after_call(data, message);
                }
                if (data.status === 'success') {
                    $('#usr_management_area').trigger('usr_manageRefreshList');
                }
            }
        }
    });
}

function usrCheckInputs(target) {
    var valid = true;
    $('#usrManageWinMsg').empty();
    $(target).find('.form-control').removeClass('invalid DonotMatch');
    if ($('#usr_ID').val().length <= 0) {
        $($(target).find('.form-control[required]').filter(function () { return this.value == ""; })).each(function () {
            $(this).addClass('invalid');
            valid = false;
        });
        if ($('#usrPassword').val() !== $('#password_confirmation').val()) {
            valid = false;
            $('#password_confirmation').addClass('DonotMatch');
        }
    } else {
        $($(target).find('.form-control[required]:not([type="password"])').filter(function () { return this.value == ""; })).each(function () {
            $(this).addClass('invalid');
            valid = false;
        });
    }
    return valid;
}

function loadUsr(uid, callback) {
    $.ajax({
        type: 'GET',
        url: usrManagementTarget + '/' + uid,
        dataType: 'json',
        complete: function (jqXHR, status) {
            var data = jqXHR.responseJSON;
            if (data !== undefined && !$.isEmptyObject(data)) {
                if (typeof (callback) === 'function') {
                    callback(uid, data);
                }
            }
        }
    });
}

function removeUsr(uid, callback) {
    $.ajax({
        type: 'POST',
        url: usrManagementTarget + '/rm/' + uid,
        dataType: 'json',
        complete: function (jqXHR, status) {
            var data = jqXHR.responseJSON;
            if (data !== undefined && !$.isEmptyObject(data)) {
                if (typeof (callback) === 'function') {
                    callback(uid, data);
                }
            }
        }
    });
}