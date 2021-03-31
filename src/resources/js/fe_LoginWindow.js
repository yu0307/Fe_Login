const { default: axios } = require("axios");

window.ready(()=>{
    var loginWindow=document.querySelector('#login_window .login');
    let info= document.querySelector('#info_Section .details');

    document.querySelectorAll('.btn_signUps').forEach((elm)=>{
        elm.addEventListener('click',()=>{
            loginWindow.querySelectorAll('.form-container:not(.sign-in-container)').forEach((e)=>{
                e.classList.add('d-none');
            });
            loginWindow.querySelector('.sign-up-container').classList.remove('d-none');
            loginWindow.classList.add('right-panel-active');
        });
    });
    document.querySelectorAll('.btn_signins').forEach((elm)=>{
        elm.addEventListener('click',()=>{
            loginWindow.classList.remove('right-panel-active');
        });
    });
    document.getElementById('btn_forgetPassword').addEventListener('click',()=>{
        loginWindow.querySelectorAll('.form-container:not(.sign-in-container)').forEach((e)=>{
            e.classList.add('d-none');
        });
        loginWindow.querySelector('.forget-password').classList.remove('d-none');
        loginWindow.classList.add('right-panel-active');
    });

    document.querySelectorAll('#login_window .login.useAjax form').forEach((f)=>{
        f.addEventListener('submit',(e)=>{
            e.preventDefault();
            f.querySelectorAll('button').forEach((b)=>{
                b.disabled=true;
            });
            data={};
            f.querySelectorAll('input:not([type="checkbox"])').forEach((elm)=>{
                data[elm['name']] = elm['value'];
            });
            f.querySelectorAll('input[type="checkbox"]:checked').forEach((elm)=>{
                data[elm['name']] = true;
            });
            info.classList.add('d-none');
            info.innerHTML='';
            axios.post(f.getAttribute('action'),data,{headers: {'X-Requested-With': 'XMLHttpRequest'}})
            .then((resp)=>{
                resp=resp.data;
                let html = resp.message;
                if(!_.isString(html)){
                    html='';
                    Object.keys(resp.message).forEach((key)=>{
                        html += "<h6 class='my-0'>" + key + "</h6>";
                        let val =resp.message[key];
                        if (!_.isString(val)) {
                            val.forEach((msg)=>{
                                html += "<div class='sub_error_itm'>" + msg + "</div>";
                            });
                        } else {
                            html += "<div class='sub_error_itm'>" + val + "</div>";
                        }
                    })
                }
                resp.status=resp.status||info;
                info.innerHTML=('<div class="alert alert-'+(resp.status=='error'?'danger':resp.status)+' info general">'+html+'</div>');
                info.classList.remove('d-none');
                if (resp.status == 'success') {
                    info.lastElementChild.innerHTML+='<div>Redirecting in 2 seconds...</div>';
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            })
            .catch((err)=>{
                console.log(err);
            })
            .then(()=>{
                f.querySelectorAll('button').forEach((b)=>{
                    b.disabled=false;
                });
            });
        });
    });
});
