var usrMetaURL;
var UsrMetaTable;
$(document).ready(function () {
    InitUsrMetaDtable($('#usrMeta_dt_table'));
    usrMetaURL = $('#usrMeta_management').attr('actionTarget');
    $('#usrMeta_management .usrmeta_addNew').click(function () {
        $('#control_CRUD .buttonSlot').html('<button class="btn btn-success usrMeta_SaveChange" id="usrMeta_SaveChange">Save Changes</button>');
        showCRUD('User_Meta_Info');
    });
    $(document).on('click', '#usrMeta_management .btn-edit', function () {
        usrMeta_load($(this).attr('data-source'), function (data) {
            $('#control_CRUD .buttonSlot').html('<button class="btn btn-success usrMeta_SaveChange" id="usrMeta_SaveChange">Update Changes</button>');
            showCRUD('User_Meta_Info');
        });
    });
    $(document).on('click', '#control_CRUD .usrMeta_SaveChange', function () {
        updateMeta();
    });
    $(document).on('click', '#usrMeta_management .btn-remove', function () {
        $.ajax({
            "type": 'POST',
            "url": usrMetaURL + '/delete/' + $(this).attr('data-source'),
            "dataType": 'json',
            complete: function (jqXHR, status) {
                var data = jqXHR.responseJSON;
                Notify(data.message, data.status);
                if (data.status == 'success') {
                    UsrMetaTable.ajax.reload();
                }
            }
        });
    });
});

function usrMeta_load(target, callback) {
    $.ajax({
        "type": 'POST',
        "url": usrMetaURL + '/load/' + target,
        "dataType": 'json',
        complete: function (jqXHR, status) {
            var data = jqXHR.responseJSON;
            if (data !== undefined && !$.isEmptyObject(data)) {
                $('#User_Meta_Info_CRUD input[name="MetaID"]').val(data.id);
                $('#User_Meta_Info_CRUD input[name="meta_name"]').val(data.meta_name);
                $('#User_Meta_Info_CRUD input[name="meta_label"]').val(data.meta_label);
                $('#User_Meta_Info_CRUD input[name="meta_defaults"]').val(data.meta_defaults);
                $('#User_Meta_Info_CRUD select[name="meta_type"]').val(data.meta_type).trigger('change');
                if (typeof (callback) == "function") {
                    callback(data);
                }
            }
        }
    });
}

function updateMeta() {
    var data = {};
    $.each($('#User_Meta_Info_CRUD .form-control').serializeArray(), function (idx, elm) {
        data[elm['name']] = elm['value'];
    });

    $.ajax({
        type: 'POST',
        url: usrMetaURL,
        dataType: 'json',
        data: data,
        complete: function (jqXHR, status) {
            var data = jqXHR.responseJSON;
            message = (data.message !== undefined) ? data.message : '';
            message += jQuery.map(data.errors, function (n, i) {
                return ('<div class="error c-red">' + i + ':' + n + '</div>');
            }).join("");
            Notify(message, (data.status !== undefined ? data.status : 'info'));
            if (data.status === 'success') {
                hideCRUD(function () {
                    $('#control_CRUD .buttonSlot').html('');
                    UsrMetaTable.ajax.reload();
                });
            }
        }
    });
}

function InitUsrMetaDtable(target) {
    UsrMetaTable = $(target).DataTable({
        "processing": true,
        "searching": false,
        "serverSide": true,
        "autoWidth": false,
        "lengthMenu": [10, 30, 50, 100],
        columns: [
            { data: 'meta_name', "width": "20%" },
            { data: 'meta_type', "width": "120px" },
            { data: 'meta_label', "width": "150px" },
            { data: 'meta_defaults', "width": "160px" },
            { data: 'meta_options' },
            { data: 'actions', "width": "160px" },
        ],
        "columnDefs": [
            { className: "options", "targets": -1 }
        ],
        "ajax": {
            "url": $(target).attr('data_target'),
            "type": "POST",
            "data": function (d) {
                d.page = $(target).DataTable().page.info().page + 1;
            },
            "dataSrc": function (json) {
                $(json.data).each(function (idx, elm) {
                    elm.actions = '<div class="row m-l-0 m-r-0"><div class="col-md-6 col-sm-12"><button class="btn btn-sm btn-primary btn-edit" data-source=' + elm.id + '>View/Edit</button></div><div class="col-md-6 col-sm-12"><button class="btn btn-sm btn-danger btn-remove" data-source=' + elm.id + '>Remove</button></div></div>';
                });

                return json.data;
            }
        },
    });
}