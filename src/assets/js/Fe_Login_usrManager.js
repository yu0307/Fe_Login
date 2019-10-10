$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#bt_usrCreate').click(function () {
        $('#usrManagementCtr input,#usrManagementCtr select,#usrManagementCtr textarea').val('').removeAttr('checked').removeClass('invalid DonotMatch');
        $('#usrManagementCtr .modal-title').text('Create a new user');
        $('#usrSave').text('Create User');
    });

    $('#usrSave').click(function () {
        if (usrCheckInputs($('#usrManagementCtr')) === true) {
            SaveUser([], function (data, message) {
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

    $('.users .usr_remove').click(function (e) {
        if (confirm('Remove this User?')) {
            removeUsr($(this).parents('.users:first').attr('uid'), function (uid, data) {
                if (data.status === 'success') {
                    LoadList();
                }
            })
        }
    });
});
