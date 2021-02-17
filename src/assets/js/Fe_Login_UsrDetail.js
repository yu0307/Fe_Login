var usrDetailModal;
window.ready(()=>{
    usrDetailModal = new bootstrap.Modal(document.getElementById('Fe_login_ProfImage'));
    document.querySelectorAll('#User_Detail .saveChange').forEach((elm)=>{
        elm.addEventListener('click',usrDetailUpdate);
    });
    document.querySelector('#Profile_Panel .usrProfile.editable').innerHTML+='<div class="ctrls"><i class="far fa-edit"></i>Edit</div>';

    document.querySelectorAll('#Profile_Panel .usrProfile.editable .ctrls').forEach((elm)=>{
        elm.addEventListener('click',(e)=>{
            var profileimg = document.querySelector('#Profile_Panel .usrProfile.editable img').getAttribute('src');
            if (profileimg.includes('www.gravatar.com')) {
                document.querySelector('.edit_prof_img_area .remove_prof_img').classList.add('visually-hidden');
            } else {
                document.querySelector('.edit_prof_img_area .remove_prof_img').classList.remove('visually-hidden');
            }
            document.querySelector('#Fe_login_ProfImage .usrProfImg_Preview').setAttribute('src', profileimg);
            usrDetailModal.show();
        });
    });
    document.querySelectorAll('.FeLogin_ProfImgUpload .inputfile').forEach((elm)=>{
        elm.addEventListener('change',(e)=>{
            var fileName = '';
            if (e.target.value) {
                fileName = e.target.value.split('\\').pop();
            }
            if (fileName)
            document.querySelector('.FeLogin_ProfImgUpload label span').innerHTML=fileName;
        });
    });

    document.querySelectorAll('#prof_img_editArea .edit_prof_img_area .remove_prof_img').forEach((elm)=>{
        elm.addEventListener('click',(e)=>{
            window.Axios.post(document.getElementById('fm_FeLogin_ProfImgUpload').getAttribute('action')+ '/remove').then((response)=>{
                window.frameUtil.Notify(response);
                if (response.data.status == 'success') {
                    document.querySelector('#prof_img_editArea .usrProfImg_Preview').setAttribute('src', '/feiron/felaraframe/images/avatars/avatar12_big.png');
                }
            })
            .catch((error)=>{
                window.frameUtil.Notify(error, 'error');
            });
        });
    });

    document.querySelectorAll('#Fe_login_ProfImage .btn-save').forEach((elm)=>{
        elm.addEventListener('click',updateProfImg);
    });
});

function updateProfImg(e){
    var bar = document.querySelector('#Fe_login_ProfImage .progress-bar');
    var percent = document.querySelector('#Fe_login_ProfImage .progress-bar .percent');
    if (document.getElementById('FeLogin_ProfImgUpload').value.length > 0) {
        document.querySelector('#Fe_login_ProfImage .progress').classList.add('d-block');
        window.Axios.post(document.getElementById('fm_FeLogin_ProfImgUpload').getAttribute('action'),new FormData(document.getElementById('fm_FeLogin_ProfImgUpload')),{
            headers: {
                "Content-Type": "multipart/form-data",
            },
            onUploadProgress: (progressEvent)=>{
                var percentVal = (parseFloat((progressEvent.loaded/progressEvent.total))*100).toFixed(2);
                bar.style.width=(percentVal+'%');
                percent.innerHTML=(percentVal+'%');
            }
        }).then(
            (response)=>{
                message = '';
                if (response.data.status == 'success') {
                    message = response.data.message;
                    document.querySelector('#prof_img_editArea .usrProfImg_Preview').setAttribute('src', response.data.datapath);
                }
                window.frameUtil.Notify(response);
                document.querySelector('.FeLogin_ProfImgUpload label span').innerHTML='Choose a file';
                document.querySelector('#Fe_login_ProfImage .progress').classList.remove('d-block');
            }
        )
        .catch(
            (error)=>{
                window.frameUtil.Notify(error, 'error');
            }
        );
    } else {
        window.frameUtil.Notify('Please select a file to upload', 'info');
    }
}

function usrDetailUpdate(e){
    e.preventDefault();
    var postdata = {};
    document.querySelectorAll('#usrDetail .form-control').forEach((elm)=>{
        postdata[elm['name']] = elm['value'];
    });
    postdata.metainfo = {};
    document.querySelectorAll('#usrDetailMetas .form-control').forEach((elm)=>{
        if (Array.isArray(postdata.metainfo[elm['name']]) === true) {
            postdata.metainfo[elm['name']].push(elm['value']);
        } else if (postdata.metainfo[elm['name']] && postdata.metainfo[elm['name']].length > 0) {
            (postdata.metainfo[elm['name']] = [postdata.metainfo[elm['name']]]).push(elm['value']);
        } else {
            postdata.metainfo[elm['name']] = elm['value'];
        }
    });
    document.querySelectorAll('#usrDetailMetas .form-control[type="checkbox"]:not(:checked)').forEach((elm)=>{
        if (!($(elm).attr('name') in postdata.metainfo)) {
            postdata.metainfo[$(elm).attr('name')] = false;
        }
    });
    window.Axios.post(document.querySelector('#usrDetailArea').getAttribute('data-target'),postdata).then(
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