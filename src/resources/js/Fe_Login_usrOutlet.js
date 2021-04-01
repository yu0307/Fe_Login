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
        new bootstrap.Tab(document.querySelector('#User_Management_CRUD li.nav-item:first-child a')).show();
        window.controlUtil.showCRUD('User_Management');
    });

    document.getElementById('usr_management_area').addEventListener('click',(e)=>{
        if (e.target.classList.contains('user_img') || e.target.classList.contains('user_prof_pics') ) {
            e.stopPropagation();
            document.querySelector('#control_CRUD .buttonSlot').innerHTML='<button class="btn btn-success usrSave" id="usrUpdateUser">Update User</button>';
            window.controlUtil.clearWorkingArea();
            window.controlUtil.showCRUD('User_Management', true);
            window.usrManagement.loadUsr(e.target.closest('.users').getAttribute('uid'), function (uid, data) {
                new bootstrap.Tab(document.querySelector('#User_Management_CRUD li.nav-item:first-child a')).show();
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
                document.querySelector('#control_CRUD .loading').classList.remove('show');
                document.getElementById('control_CRUD').dispatchEvent(new CustomEvent('usrInfoLoaded',{detail:{usrData:data}}));
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

    document.getElementById('control_CRUD').addEventListener('click',(e)=>{
        if (e.target.classList.contains('usrSave')) {
            e.stopPropagation();
            window.usrManagement.SaveUser([], function (data, message) {
                if (data.status === 'success') {
                    window.controlUtil.hideCRUD(function () {
                        document.querySelector('#control_CRUD .buttonSlot').innerHTML="";
                    });
                }
            });
        }
    });
});