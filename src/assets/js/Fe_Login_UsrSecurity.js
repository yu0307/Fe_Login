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
    document.querySelector('#usrSecurityArea').querySelectorAll('.saveChange').forEach((elm)=>{
        elm.addEventListener('click',usrSecurityUpdate);
    });
});

function usrSecurityUpdate(e){
        e.preventDefault();
        var postdata = {};
        document.querySelectorAll('#usrSecurityArea .form-control').forEach((elm)=>{
            postdata[elm['name']] = elm['value'];
        });
        postdata.metainfo = {};
        document.querySelectorAll('#usrSecurityAreaMetas .form-control').forEach((elm)=>{
            postdata.metainfo[elm['name']] = elm['value'];
        });
        window.Axios.post(document.querySelector('#usrSecurityArea').getAttribute('data-target'),postdata).then(
            (response)=>{
                window.frameUtil.Notify(response);
            }
        )
        .catch(
            (error)=>{
                window.frameUtil.Notify(error, 'error');
            }
        );
}