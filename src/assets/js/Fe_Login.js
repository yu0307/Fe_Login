$(document).ready(function(){
    $('.swap_ctrl').on('click', function (e) {
        e.preventDefault();
        var tar = $('#Fe_login-block .' + $(this).attr('wintarget'));
        $('#Fe_login-block .Fe_ctrl_windows').slideUp(300, function () {
            tar.slideDown(300);
        });
    });
});
