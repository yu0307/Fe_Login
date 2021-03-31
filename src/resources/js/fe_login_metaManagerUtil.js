import axios from "axios";
import Tabulator from 'tabulator-tables';
import 'tabulator-tables/dist/css/tabulator.min.css'

var usrMetaURL;
var UsrMetaTable;

function usrMeta_load(target, callback) {
    axios.post(this.usrMetaURL + '/load/' + target).then((resp)=>{
        if (resp.data !== undefined && !_.isEmpty(resp.data)) {
            document.querySelector('#User_Meta_Info_CRUD input[name="MetaID"]').value=resp.data.id
            document.querySelector('#User_Meta_Info_CRUD input[name="meta_name"]').value=resp.data.meta_name
            document.querySelector('#User_Meta_Info_CRUD input[name="meta_label"]').value=resp.data.meta_label
            document.querySelector('#User_Meta_Info_CRUD input[name="meta_defaults"]').value=resp.data.meta_defaults
            document.querySelector('#User_Meta_Info_CRUD input[name="meta_options"]').value=resp.data.meta_options
            document.querySelector('#User_Meta_Info_CRUD select[name="meta_type"]').value=resp.data.meta_type
            if (typeof (callback) == "function") {
                callback(resp.data);
            }
        }
    }).catch((error)=>{
        window.frameUtil.Notify(error);
    });
}

function updateMeta() {
    var data = {};
    var self = this;
    document.querySelectorAll('#User_Meta_Info_CRUD .form-control').forEach((elm)=>{
        data[elm['name']] = elm['value'];
    });

    axios.post(this.usrMetaURL, data).then((resp)=>{
        window.frameUtil.Notify(resp);
        if (resp.data.status === 'success') {
            if(window.controlUtil){
                window.controlUtil.hideCRUD(function () {
                    document.querySelector('#control_CRUD .buttonSlot').innerHTML="";
                    self.UsrMetaTable.setData();
                });
            }else{
                self.UsrMetaTable.setData();
            }
        }
    }).catch((error)=>{
        window.frameUtil.Notify(error);
    });
}

function InitUsrMetaDtable(target) {

    this.UsrMetaTable = new Tabulator('#'+target, {
        ajaxURL:document.getElementById(target).getAttribute('data_target'),
        columns:[
            {title:"id", field:"id", visible:false}, 
            {title:"Name", field:"meta_name", sorter:"string", headerFilter:"input"}, 
            {title:"Type", field:"meta_type", sorter:"string", width:120,headerFilter:"input"},
            {title:"Label", field:"meta_label", sorter:"string", width:150,headerFilter:"input"},
            {title:"Default", field:"meta_defaults", sorter:"string", width:160, headerSort:false},
            {title:"Options", field:"meta_options", sorter:"string", headerSort:false},
            {title:"Actions", field:"actions", width:180, cssClass:'options', headerSort:false, formatter:(cell, formatterParams, onRendered)=>{
                let id = cell.getRow().getCell("id").getValue();
                return '<div class="container-fluid"><div class="row m-l-0 m-r-0"><div class="col-md-6 col-sm-12 px-1"><button class="btn btn-sm btn-primary btn-edit" data-source=' + id + '>View/Edit</button></div><div class="col-md-6 col-sm-12 px-1"><button class="btn btn-sm btn-danger btn-remove" data-source=' + id + '>Remove</button></div></div></div>'
            }}
        ],
        responsiveLayout:true,
        resizableColumns:false,
        layout:"fitColumns",
        ajaxFiltering:true,
        ajaxSorting:true,
        pagination:"remote",
        paginationSize:15,
        paginationSizeSelector:[30, 50, 100, true],
        ajaxConfig:{
            method:"POST", //set request type to Position
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        },
        ajaxError:function(error){
            window.frameUtil.Notify(error, 'error');
        }
    });
}

export default{
    usrMeta_load,
    updateMeta,
    InitUsrMetaDtable,
    UsrMetaTable,
    usrMetaURL
}