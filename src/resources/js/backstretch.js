import Noty from 'noty';

window.ready(()=>{
    let idx = 0;
    let imgs = document.querySelectorAll('.backgroundimgs');
    setInterval(() => {
        idx= (idx+1>=imgs.length)?0:(idx+1);
        imgs[idx==0?(imgs.length-1):(idx-1)].classList.remove('active');
        imgs[idx].classList.add('active');
    }, 4000);
});

window.frameUtil={};
window.frameUtil.Notify = function Notify(message, type, position, container, confirm, method) {
    type=(message.error||message.isAxiosError)?'error':((message.data?message.data.status:type)||'success');
    message=message.response?message.response.data : (message.data||message);
    message=message.success || message.error|| message.errors || message.message || message ;
    if(Array.isArray(message)){
        Array.from(message).forEach(element => {
            message=(element.message || element)+'<br/>';
        });
    }else if((typeof message == 'object') && Array.isArray(Object.keys(message))){
        Object.keys(message).forEach((key)=>{
            message.message=(message.message||'')+'<div><h5>'+key+'</h5><p>'+message[key].join('<br/>')+'</p></div>';
        })
    }
    message=message.message || message;

    position = position || 'topCenter';
    container = container || '';
    confirm = confirm || false;
    method = method || 3000;
    let openAnimation = 'animate__animated animate__bounceIn';
    let closeAnimation = 'animate__animated animate__bounceOut';
    if (position == 'bottom') {
        openAnimation = 'animate__animated animate__fadeInUp';
        closeAnimation = 'animate__animated animate__fadeOutDown';
    }
    else if (position == 'top' || container.length > 1) {
        openAnimation = 'animate__animated animate__fadeIn';
        closeAnimation = 'animate__animated animate__fadeOut';
    }
    if(message){
        new Noty({
            text: message,
            type: type,
            layout: position,
            timeout: method,
            container: container,
            theme: 'bootstrap-v4',
            dismissQueue: true,
            closeWith: ['click'],
            maxVisible: 10,
            progressBar: true,
            animation: {
                open: openAnimation,
                close: closeAnimation,
                easing: 'swing',
                speed: 70
            },
            buttons: confirm ? [
                Noty.button('Ok', 'btn btn-primary', function ($noty) {
                    $noty.close();
                    confirm = false;
                }, { id: 'button1', 'data-status': 'ok' })
            ] : '',
            callback: {
                onShow: function () {
                    if (container == '') {
                        leftNotfication = $('.sidebar').width();
                        if ($('body').hasClass('rtl')) {
                            if (position == 'top' || position == 'bottom') {
                                $('#noty_layout_top').css('margin-right', leftNotfication).css('left', 0);
                                $('#noty_layout_bottom').css('margin-right', leftNotfication).css('left', 0);
                            }
                            if (position == 'topRight' || position == 'centerRight' || position == 'bottomRight') {
                                $('#noty_layout_centerRight').css('right', leftNotfication + 20);
                                $('#noty_layout_topRight').css('right', leftNotfication + 20);
                                $('#noty_layout_bottomRight').css('right', leftNotfication + 20);
                            }
                        }
                        else {
                            if (position == 'top' || position == 'bottom') {
                                $('#noty_layout_top').css('margin-left', leftNotfication).css('right', 0);
                                $('#noty_layout_bottom').css('margin-left', leftNotfication).css('right', 0);
                            }
                            if (position == 'topLeft' || position == 'centerLeft' || position == 'bottomLeft') {
                                $('#noty_layout_centerLeft').css('left', leftNotfication + 20);
                                $('#noty_layout_topLeft').css('left', leftNotfication + 20);
                                $('#noty_layout_bottomLeft').css('left', leftNotfication + 20);
                            }
                        }
                    }
                }
            }
        }).show();
    }
}

