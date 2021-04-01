var usrModal;
window.ready(()=>{
    usrModal = new bootstrap.Modal(document.getElementById('usrManagementCtr'));
    document.getElementById('usrManagementCtr').addEventListener('hidden.bs.modal',clearWorkingArea);
    document.getElementById('btn_usrCreate').addEventListener('click',()=>{
        new bootstrap.Tab(document.querySelector('#usrManagementCtr li.nav-item:first-child a')).show();
        document.querySelector('#usrManagementCtr .modal-title').innerText="Create a new user";
        document.querySelector('#usrSave').innerText="Create User";
        showModal();
    });
    document.getElementById('usr_management_area').addEventListener('click',(e)=>{
        if (e.target.classList.contains('user_img') || e.target.classList.contains('user_prof_pics') ) {
            e.stopPropagation();
            document.querySelector('#usrManagementCtr .loading').classList.add('show');
            document.querySelector('#usrManagementCtr .modal-title').innerText='Update User information';
            document.getElementById('usrSave').innerText='Update User';
            showModal();
            window.usrManagement.loadUsr(e.target.closest('.users').getAttribute('uid'), function (uid, data) {
                new bootstrap.Tab(document.querySelector('#usrManagementCtr li.nav-item:first-child a')).show();
                document.getElementById('usr_ID').value=uid;
                document.getElementById('usrName').value=data.name;
                document.getElementById('email').value=data.email;
                (data.metainfo||[]).forEach((meta)=>{
                    switch (document.querySelector('#Additional_Info .form-control[name="' + meta.meta_name + '"]').getAttribute('type')) {
                        case 'checkbox':
                            if(document.querySelector('#Additional_Info .form-control[name="' + meta.meta_name + '"]').hasAttribute('toggle')){
                                document.querySelector('#Additional_Info .form-control[name="' + meta.meta_name + '"]').checked=(meta.meta_value=='on');
                            }else{
                                document.querySelectorAll('#Additional_Info .form-control[name="' + meta.meta_name + '"]').forEach((elm)=>{
                                    elm.checked=false;
                                });
                                (meta.meta_value||'').split(',').forEach((val)=>{
                                    document.querySelector('#Additional_Info .form-control[name="' + meta.meta_name + '"][value="' + val + '"]').checked=true;
                                });
                            }
                            break;
                        case 'radio':
                            document.querySelector('#Additional_Info .form-control[name="' + meta.meta_name + '"][value="' + meta.meta_value + '"]').checked=true;
                            break;
                        case 'select':
                            if(_.isNull(meta.meta_value)) document.querySelector('#Additional_Info .form-control[name="' + meta.meta_name + '"]').value=document.querySelector('#Additional_Info .form-control[name="select"] option[default]').value;
                            else document.querySelector('#Additional_Info .form-control[name="' + meta.meta_name + '"]').value=meta.meta_value;
                            break;
                        default:
                            document.querySelector('#Additional_Info .form-control[name="' + meta.meta_name + '"]').value=meta.meta_value;
                    }
                });
                document.querySelector('#usrManagementCtr .loading').classList.remove('show');
                document.getElementById('usrManagementCtr').dispatchEvent(new CustomEvent('usrInfoLoaded',{detail:{usrData:data}}));
            });
        }else if (e.target.classList.contains('usr_remove')) {
            if (confirm('Remove this User?')) {
                window.usrManagement.removeUsr(e.target.closest('.users').getAttribute('uid'), function (uid, data) {
                    window.frameUtil.Notify(data.message, (data.status !== undefined ? data.status : 'info'));
                    if (data.status === 'success') {
                        window.usrManagement.LoadList();
                    }
                })
            }
        }
    });

    document.getElementById('usrSave').addEventListener('click',(e)=>{
        e.stopPropagation();
        window.usrManagement.SaveUser([], function (data, message) {
            if (data.status === 'success') {
                usrModal.hide();
            }
        });
    });
});

function showModal(){
    usrModal.show();
    document.querySelector('#usrManagementCtr').dispatchEvent(new CustomEvent('shown-User_Management'));
}

function clearWorkingArea(){
    document.querySelectorAll('#usrManagementCtr input:not([type="radio"],[type="checkbox"]), #usrManagementCtr textarea, #usrManagementCtr select').forEach((elm)=>{
        elm.value="";
    });
    document.querySelectorAll('#usrManagementCtr input[type="radio"],#usrManagementCtr input[type="checkbox"]').forEach((elm)=>{
        elm.classList.remove('checked');
        elm.checked=false;
    });

    document.querySelectorAll('#usrManagementCtr input[type="radio"].default,#usrManagementCtr input[type="checkbox"].default').forEach((elm)=>{
        elm.checked=true;
    });

    document.querySelectorAll('#usrManagementCtr select').forEach((elm)=>{
        elm.value=(elm.querySelector('option[default]')||{value:""}).value;
    });
}