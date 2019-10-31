$(document).ready(function () {
    $('#User_Details .saveChange').click(function (e) {
        e.preventDefault();
        var l = Ladda.create(this);
        var postdata = {};
        $.each($('#usrDetail .form-control').serializeArray(), function (idx, elm) {
            postdata[elm['name']] = elm['value'];
        });
        postdata.metainfo = {};
        $.each($('#usrDetailMetas .form-control').serializeArray(), function (idx, elm) {
            if (Array.isArray(postdata.metainfo[elm['name']]) === true) {
                postdata.metainfo[elm['name']].push(elm['value']);
            } else if (postdata.metainfo[elm['name']] && postdata.metainfo[elm['name']].length > 0) {
                (postdata.metainfo[elm['name']] = [postdata.metainfo[elm['name']]]).push(elm['value']);
            } else {
                postdata.metainfo[elm['name']] = elm['value'];
            }
        });
        $.each($('#usrDetailMetas .form-control[type="checkbox"]:not(:checked)'), function (idx, elm) {
            if (!($(elm).attr('name') in postdata.metainfo)) {
                postdata.metainfo[$(elm).attr('name')] = false;
            }
        });
        $.ajax({
            'type': 'POST',
            'dataType': 'json',
            'url': $('#usrDetailArea').attr('data-target'),
            'data': postdata,
            'complete': function (jqXHR, status) {
                var data = jqXHR.responseJSON;
                if (data.message !== undefined) {
                    message = data.message;
                    message += jQuery.map(data.errors, function (n, i) {
                        return ('<div class="error c-red">' + i + ':' + n + '</div>');
                    }).join("");
                    Notify(message, (data.status !== undefined ? data.status : 'info'));
                }
                l.stop();
            }
        });
    });
    $('#Profile_Panel .usrProfile.editable').append('<div class="ctrls"><i class="fa fa-pencil-square-o">Edit</i></div>');

    $(document).on('click', '#Profile_Panel .usrProfile.editable .ctrls', function () {
        var profileimg = $(this).parent().find('img').attr('src');
        if (profileimg.includes('www.gravatar.com')) {
            $('.edit_prof_img_area .remove_prof_img').hide();
        } else {
            $('.edit_prof_img_area .remove_prof_img').show();
        }
        $('#Fe_login_ProfImage .usrProfImg_Preview').attr('src', $(this).parent().find('img').attr('src'));
        $('#Fe_login_ProfImage').modal('show');
    });

    $(document).on('change', '.FeLogin_ProfImgUpload .inputfile', function (e) {
        var fileName = '';
        if (e.target.value) {
            fileName = e.target.value.split('\\').pop();
        }
        if (fileName)
            $(this).next('label').find('span').html(fileName);
    });
    $(document).on('click', '.edit_prof_img_area .remove_prof_img', function (e) {
        $.ajax({
            url: $('#fm_FeLogin_ProfImgUpload').attr('action') + '/remove',
            type: 'post',
            dataType: 'json',
            complete: function (data) {
                resp = data.responseJSON;
                if (resp.status == 'success') {
                    $('#prof_img_editArea .usrProfImg_Preview').attr('src', '/feiron/felaraframe/images/avatars/avatar12_big.png');
                }
                Notify(resp.message, (resp.status !== undefined ? resp.status : 'info'));
            }
        });
    });


    $(document).on('click', '#Fe_login_ProfImage .btn-save', function (e) {
        var bar = $('#Fe_login_ProfImage .progress-bar');
        var percent = $('#Fe_login_ProfImage .progress-bar .percent');
        if ($('#FeLogin_ProfImgUpload').val().length > 0) {
            $('#Fe_login_ProfImage .progress').fadeIn(100);
            $.ajax({
                url: $('#fm_FeLogin_ProfImgUpload').attr('action'),
                type: 'post',
                data: new FormData($('#fm_FeLogin_ProfImgUpload')[0]),
                contentType: false,
                processData: false,
                xhr: function () {
                    var xhr = $.ajaxSettings.xhr();
                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', function (event) {
                            var percentVal = 0;
                            var position = event.loaded || event.position;
                            var total = event.total;
                            if (event.lengthComputable) {
                                percentVal = Math.ceil(position / total * 100);
                            }

                            $(bar).width((percentVal + '%'))
                            $(percent).html(percentVal + '%');
                        }, true);
                    }
                    return xhr;
                }
            }).done(function (data) {
                message = '';
                if (data.status == 'success') {
                    message = data.message;
                    $('#prof_img_editArea .usrProfImg_Preview').attr('src', data.datapath);
                } else {
                    message += jQuery.map(data.errors, function (n, i) {
                        return ('<div class="error c-red">' + i + ':' + n + '</div>');
                    }).join("");
                }
                Notify(message, (data.status !== undefined ? data.status : 'info'));
                $('.FeLogin_ProfImgUpload label span').html('Choose a file');
                $('#Fe_login_ProfImage .progress').fadeOut(100);
            });
        } else {
            Notify('Please select a file to upload', 'info');
        }
    });
});