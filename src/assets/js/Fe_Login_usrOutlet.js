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
    document.getElementById('btn_usrCreate').addEventListener('click',()=>{
        document.querySelector('#control_CRUD .buttonSlot').innerHTML='<button class="btn btn-success usrSave" id="usrCreateUser">Create User</button>';
        // document.querySelector('#User_Management_CRUD a:first').tab('show');
        window.controlUtil.showCRUD('User_Management');
    });

    document.getElementById('usr_management_area').addEventListener('click',(e)=>{
        if (e.target.classList.contains('usrSave')) {
            e.stopPropagation();
            window.usrManagement.SaveUser([], function (data, message) {
                window.frameUtil.Notify(message, (data.status !== undefined ? data.status : 'info'));
                if (data.status === 'success') {
                    window.controlUtil.hideCRUD(function () {
                        document.querySelector('#control_CRUD .buttonSlot').innerHTML="";
                    });
                }
            });
        }else if (e.target.classList.contains('user_img')) {
            e.stopPropagation();
            document.querySelector('#control_CRUD .buttonSlot').innerHTML='<button class="btn btn-success usrSave" id="usrUpdateUser">Update User</button>';
            window.controlUtil.clearWorkingArea();
            window.controlUtil.showCRUD('User_Management', true);
            window.usrManagement.loadUsr(e.target.closest('.users').getAttribute('uid'), function (uid, data) {
                // $('#User_Management_CRUD a:first').tab('show')
                document.getElementById('usr_ID').value=uid;
                document.getElementById('usrName').value=data.name;
                document.getElementById('email').value=data.email;
                (data.metainfo||[]).forEach((meta)=>{
                    switch (document.querySelector('#Additional_Info .form-control[name="' + meta.meta_name + '"]').getAttribute('type')) {
                        case 'checkbox':
                        case 'radio':
                            if (Array.isArray(meta.meta_value) !== false) {
                                (meta.meta_value||[]).forEach((metavalue)=>{
                                    document.querySelector('#Additional_Info .form-control[name="' + meta.meta_name + '"][value="' + metavalue + '"]').setAttribute('checked', 'checked');
                                });
                            } else {
                                document.querySelector('#Additional_Info .form-control[name="' + meta.meta_name + '"][value="' + meta.meta_value + '"]').setAttribute('checked', 'checked');
                            }
                            break;
                        default:
                            document.querySelector('#Additional_Info .form-control[name="' + meta.meta_name + '"]').value=meta.meta_value;
                    }
                });
                document.querySelector('#control_CRUD .loading').classList.remove('show');
                document.getElementById('User_Management_CRUD').dispatchEvent(new CustomEvent('usrInfoLoaded',data));
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
});