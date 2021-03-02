const { default: axios } = require('axios');

window.usrMetaManager = require('./fe_login_metaManagerUtil').default;

window.ready = window.ready|| function(refCall=null){
    if(typeof refCall ==='function'){
        if (
            document.readyState === "complete" ||
            (document.readyState !== "loading" && !document.documentElement.doScroll)
        ) {
            refCall();
        } else {
            document.addEventListener("DOMContentLoaded", refCall);
        }
    };    
}

window.ready(()=>{
    window.usrMetaManager.InitUsrMetaDtable('usrMeta_dt_table');
    window.usrMetaManager.usrMetaURL=document.getElementById('usrMeta_management').getAttribute('actionTarget');

    document.querySelectorAll('#usrMeta_management .usrmeta_addNew').forEach((elm)=>{
        elm.addEventListener('click',()=>{
            document.querySelector('#control_CRUD .buttonSlot').innerHTML='<button class="btn btn-success usrMeta_SaveChange" id="usrMeta_SaveChange">Save Changes</button>';
            window.controlUtil.showCRUD('User_Meta_Info');
        });
    });

    document.getElementById('usrMeta_management').addEventListener('click',(e)=>{
        if (e.target.classList.contains('btn-edit')) {
            window.usrMetaManager.usrMeta_load(e.target.getAttribute('data-source'), function (data) {
                document.querySelector('#control_CRUD .buttonSlot').innerHTML='<button class="btn btn-success usrMeta_SaveChange" id="usrMeta_SaveChange">Update Changes</button>';
                window.controlUtil.showCRUD('User_Meta_Info');
            });
        }else if (e.target.classList.contains('btn-remove')) {
            axios.post(window.usrMetaManager.usrMetaURL + '/delete/' + e.target.getAttribute('data-source')).then((resp)=>{
                window.frameUtil.Notify(resp);
                if (resp.data.status == 'success') {
                    window.usrMetaManager.UsrMetaTable.setData();
                }
            }).catch((error)=>{
                window.frameUtil.Notify(error);
            });
        }
    });
    document.getElementById('control_CRUD').addEventListener('click',(e)=>{
        if (e.target.classList.contains('usrMeta_SaveChange')) {
            window.usrMetaManager.updateMeta();
        }
    });
});

