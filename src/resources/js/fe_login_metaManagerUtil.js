import axios from "axios";

var usrMetaURL;
var UsrMetaTable;

function usrMeta_load(target, callback) {
    axios.post(usrMetaURL + '/load/' + target).then((resp)=>{
        if (resp.data !== undefined && !_.isEmpty(resp.data)) {
            document.querySelector('#User_Meta_Info_CRUD input[name="MetaID"]').value=data.id
            document.querySelector('#User_Meta_Info_CRUD input[name="meta_name"]').value=data.meta_name
            document.querySelector('#User_Meta_Info_CRUD input[name="meta_label"]').value=data.meta_label
            document.querySelector('#User_Meta_Info_CRUD input[name="meta_defaults"]').value=data.meta_defaults
            document.querySelector('#User_Meta_Info_CRUD input[name="meta_options"]').value=data.meta_options
            document.querySelector('#User_Meta_Info_CRUD select[name="meta_type"]').value=data.meta_type
            if (typeof (callback) == "function") {
                callback(data);
            }
        }
    }).catch((error)=>{
        window.frameUtil.Notify(error);
    });
}

function updateMeta() {
    var data = {};
    
    document.querySelectorAll('#User_Meta_Info_CRUD .form-control').forEach((elm)=>{
        data[elm['name']] = elm['value'];
    });

    axios.post(usrMetaURL, data).then((resp)=>{
        window.frameUtil.Notify(resp);
        if (resp.data.status === 'success') {
            window.controlUtil.hideCRUD(function () {
                document.querySelector('#control_CRUD .buttonSlot').innerHTML="";
                // UsrMetaTable.ajax.reload();
            });
        }
    }).catch((error)=>{
        window.frameUtil.Notify(error);
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

export default{
    usrMeta_load,
    updateMeta,
    InitUsrMetaDtable,
    UsrMetaTable
}