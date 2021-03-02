import axios from "axios";
var usrManagementTarget = '';
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
    document.getElementById('usr_management_area').addEventListener('usr_manageRefreshList',()=>{
        window.usrManagement.LoadList();
    });
    usrManagementTarget = document.getElementById('usr_management_area').getAttribute('actionTarget');
});

function SaveUser(ex_data = {}, after_call = null) {
    var data = {};
    document.querySelectorAll('#usrBasic .form-control').forEach((elm)=>{
        data[elm['name']] = elm['value'];
    });
    data.metainfo = {};
    document.querySelectorAll('#Additional_Info .form-control').forEach((elm)=>{
        if (Array.isArray(data.metainfo[elm['name']]) === true) {
            data.metainfo[elm['name']].push(elm['value']);
        } else if (data.metainfo[elm['name']] && data.metainfo[elm['name']].length > 0) {
            (data.metainfo[elm['name']] = [data.metainfo[elm['name']]]).push(elm['value']);
        } else {
            data.metainfo[elm['name']] = elm['value'];
        }
    });
    document.querySelectorAll('#Additional_Info .form-control[type="checkbox"]:not(:checked)').forEach((elm)=>{
        if (!($(elm).attr('name') in data.metainfo)) {
            data.metainfo[$(elm).attr('name')] = false;
        }
    });
    data = _.extend(data, ex_data);
    axios.post(usrManagementTarget,data).then((response)=>{
        window.frameUtil.Notify(response);
        if (response.data.message !== undefined) {
            if (typeof (after_call) === 'function') {
                after_call(response.data, response.data.message);
            }
            if (response.data.status === 'success') {
                document.getElementById('usr_management_area').dispatchEvent(new Event('usr_manageRefreshList'));
            }
        }
    }).catch((error)=>{
        window.frameUtil.Notify(error, 'error');
    });
}

function usrCheckInputs(target) {
    var valid = true;
    document.getElementById().innerHTML='';
    target.querySelectorAll('.form-control').forEach((e)=>{
        e.classList.remove('invalid','DonotMatch');
    });
    if (document.getElementById('usr_ID').value.length <= 0) {
        target.querySelectorAll('.form-control[required][value=""]').forEach((elm)=>{
            elm.classList.add('invalid');
            valid = false;
        });
        if (document.getElementById('usrPassword').value !== document.getElementById('password_confirmation').value) {
            valid = false;
            document.getElementById('password_confirmation').classList.add('DonotMatch');
        }
    } else {
        target.querySelectorAll('.form-control[required][value=""]:not([type="password"])').forEach((elm)=>{
            elm.classList.add('invalid');
            valid = false;
        });
    }
    return valid;
}

function loadUsr(uid, callback) {
    axios.get(usrManagementTarget + '/' + uid).then((resp)=>{
        if (resp.data !== undefined && !_.isEmpty(resp.data)) {
            if (typeof (callback) === 'function') {
                callback(uid, resp.data);
            }
        }
    }).catch((error)=>{
        window.frameUtil.Notify(error,'error');
    })
}

function removeUsr(uid, callback) {
    axios.post(usrManagementTarget + '/rm/' + uid).then((resp)=>{
        if (resp.data !== undefined && !_.isEmpty(resp.data)) {
            if (typeof (callback) === 'function') {
                callback(uid, resp.data);
            }
        }
    }).catch((error)=>{
        window.frameUtil.Notify(error);
    });
}

function LoadList() {
    anime({
        targets:'#usr_management_area .user_list',
        opacity:0,
        duration: 300,
        easing:'linear',
        complete: function() {
            document.querySelector('#usr_management_area .user_list').innerHTML='<div class="fa-3x text-center"><i class="fas fa-circle-notch fa-spin p-0 fa fa-circle-o-notch fa-fw"></i><div><h4 class="t-center text-center">Loading ...</h4></div></div >';
            anime({
                targets:'#usr_management_area .user_list',
                opacity:1,
                duration: 300,
                easing:'linear',
                complete: function() {
                    axios.post(usrManagementTarget + '/load').then((response)=>{
                        anime({
                            targets:'#usr_management_area .user_list',
                            opacity:1,
                            duration: 300,
                            easing:'linear',
                            complete: function() {
                                var user_list = document.querySelector('#usr_management_area .user_list')
                                user_list.innerHTML='';
                                response=response.data;
                                if (response.data !== undefined && response.data.length > 0) {
                                    response.data.forEach(elm => {
                                        user_list.innerHTML+='<div class="users" UID="' + elm.id + '">' +
                                        '<div class="usr_remove text-center t-center"><i class="animate__animated animate__fadeOutDown far fa-times-circle c-red fa-lg p-0"></i></div>' +
                                        '<div class="user_img" > <img class="user_prof_pics img-circle rounded-circle" src="' + elm.img + '"></div>' +
                                        '<div class="user_names t-center text-center">' + elm.name + '</div>' +
                                        '</div >';
                                    });
                                } else {
                                    user_list.innerHTML='<p>There are no users...</p>';
                                }
                                $('.user_list').fadeIn(300);
                            }.bind(response)
                        });
                    }).catch((error)=>{
                        window.frameUtil.Notify(error, 'error');
                    });
                }
            });
        }
    })
}

export default{
    SaveUser,
    usrCheckInputs,
    loadUsr,
    removeUsr,
    LoadList
}