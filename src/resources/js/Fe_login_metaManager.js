const { default: axios } = require('axios');

window.usrMetaManager = require('./fe_login_metaManagerUtil').default;

window.ready(()=>{
    let usrModal = new bootstrap.Modal(document.getElementById('usrMetaManagementCtr'));
    document.getElementById('usrMetaManagementCtr').addEventListener('hidden.bs.modal',clearWorkingArea);

    window.usrMetaManager.InitUsrMetaDtable('usrMeta_dt_table');
    window.usrMetaManager.usrMetaURL=document.getElementById('usrMeta_management').getAttribute('actionTarget');

    document.querySelectorAll('#usrMeta_management .usrmeta_addNew').forEach((elm)=>{
        elm.addEventListener('click',()=>{
            document.querySelector('#usrMetaManagementCtr .modal-title').innerText="Create New Meta Field";
            usrModal.show();
        });
    });

    document.getElementById('usrMeta_management').addEventListener('click',(e)=>{
        if (e.target.classList.contains('btn-edit')) {
            document.querySelector('#usrMetaManagementCtr .loading').classList.add('show');
            document.querySelector('#usrMetaManagementCtr .modal-title').innerText='Update Meta information';
            usrModal.show();
            window.usrMetaManager.usrMeta_load(e.target.getAttribute('data-source'), function (data) {
                document.querySelector('#usrMetaManagementCtr .loading').classList.remove('show');
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
    document.getElementById('usrMetaSave').addEventListener('click',(e)=>{
        e.stopPropagation();
        window.usrMetaManager.updateMeta();
        usrModal.hide();
    });
});

function clearWorkingArea(){
    document.querySelectorAll('#usrMetaManagementCtr input:not([type="radio"],[type="checkbox"]), #usrMetaManagementCtr textarea, #usrMetaManagementCtr select').forEach((elm)=>{
        elm.value="";
    });
    document.querySelectorAll('#usrMetaManagementCtr input[type="radio"],#usrMetaManagementCtr input[type="checkbox"]').forEach((elm)=>{
        elm.classList.remove('checked');
        elm.checked=false;
    });

    document.querySelectorAll('#usrMetaManagementCtr input[type="radio"].default,#usrMetaManagementCtr input[type="checkbox"].default').forEach((elm)=>{
        elm.checked=true;
    });

    document.querySelectorAll('#usrMetaManagementCtr select').forEach((elm)=>{
        elm.value=(elm.querySelector('option[default]')||{value:""}).value;
    });
}