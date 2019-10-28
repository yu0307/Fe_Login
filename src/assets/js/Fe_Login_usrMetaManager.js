$(document).ready(function () {
    $('#usrMeta_management .usrmeta_addNew').click(function () {
        $('#control_CRUD .buttonSlot').html('<button class="btn btn-success usrMeta_SaveChange" id="usrMeta_SaveChange">Save Changes</button>');
        showCRUD('Meta_Info_Management');
    });
});