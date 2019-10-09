var usrManagementTarget = '';
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    usrManagementTarget = $('#usr_management_area').attr('actionTarget');
    $('#bt_usrCreate').click(function () {
        $('#usrManagementCtr input,#usrManagementCtr select,#usrManagementCtr textarea').val('').removeAttr('checked').removeClass('invalid DonotMatch');
        $('#usrManagementCtr .modal-title').text('Create a new user');
        $('#usrSave').text('Create User');
    });
    $('#usrSave').click(function () {
        if (usrCheckInputs() === true) {
            CreateUser([], function (data, message) {
                if (typeof Notify === 'function') {
                    Notify(message, (data.status !== undefined ? data.status : 'info'));
                } else {
                    $('#usrManageWinMsg').html(message).slideDown(300, 'linear', function () {
                        setTimeout(function () {
                            $('#usrManageWinMsg').slideUp(300, 'linear', function () {
                                $('#usrManageWinMsg').empty();
                            });
                        }, 6000);
                    });
                }
                if (data.status === 'success') {
                    $('#usrManagementCtr').modal('hide')
                }
            });
        }
    });
});

function usrCheckInputs() {
    var valid = true;
    $('#usrManageWinMsg').empty();
    $('#usrManagementCtr .form-control').removeClass('invalid DonotMatch');
    $($('#usrManagementCtr .form-control[required]').filter(function () { return this.value == ""; })).each(function () {
        $(this).addClass('invalid');
        valid = false;
    });
    if ($('#usrPassword').val() !== $('#password_confirmation').val()) {
        valid = false;
        $('#password_confirmation').addClass('DonotMatch');
    }
    return valid;
}
