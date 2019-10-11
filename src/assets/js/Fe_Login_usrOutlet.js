$(document).ready(function () {
    $('#btn_usrCreate').click(function () {
        $('#control_CRUD .buttonSlot').html('<button class="btn btn-success usrSave" id="usrCreateUser">Create User</button>');
        $('#User_Management_CRUD a:first').tab('show')
        showCRUD('User_Management');
    });
    $(document).on("click", '.usrSave', function (event) {
        SaveUser([], function (data, message) {
            Notify(message, (data.status !== undefined ? data.status : 'info'));
            if (data.status === 'success') {
                hideCRUD(function () {
                    $('#control_CRUD .buttonSlot').html('');
                });
            }
        });
    });
    $(document).on('click', '.users .user_img', function (e) {
        $('#control_CRUD .buttonSlot').html('<button class="btn btn-success usrSave" id="usrUpdateUser">Update User</button>');
        showCRUD('User_Management', true);
        loadUsr($(this).parents('.users:first').attr('uid'), function (uid, data) {
            $('#User_Management_CRUD a:first').tab('show')
            $('.User_Management #usr_ID').val(uid);
            $('.User_Management #usrName').val(data.name);
            $('.User_Management #email').val(data.email);
            $.each(data.metainfo, function (idx, meta) {
                $('#usrMeta .form-control[name="' + meta.meta_name + '"]').val(meta.meta_value);
            });
            $('#control_CRUD .loading').removeClass('show');
        });
    });

    $(document).on('click', '.users .usr_remove', function (e) {
        if (confirm('Remove this User?')) {
            removeUsr($(this).parents('.users:first').attr('uid'), function (uid, data) {
                Notify(data.message, (data.status !== undefined ? data.status : 'info'));
                if (data.status === 'success') {
                    LoadList();
                }
            })
        }
    });
});