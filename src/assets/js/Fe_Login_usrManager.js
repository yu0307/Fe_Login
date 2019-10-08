$(document).ready(function () {
    $('#bt_usrCreate').click(function () {
        $('#usrManagementCtr input,#usrManagementCtr select,#usrManagementCtr textarea').val('').removeAttr('checked');
        $('#usrManagementCtr .modal-title').text('Create a new user');
        $('#usrSave').text('Create User');
    });

});
