window.usrManagement = require('./fe_Login_usrManagerUtil');
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

