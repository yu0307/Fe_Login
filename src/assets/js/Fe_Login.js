$(document).ready(function(){
    $('.swap_ctrl').click(function(e){
        e.preventDefault();
        $('#Fe_login-block .Fe_ctrl_windows').slideUp(300);
        $('#Fe_login-block .' + $(this).attr('wintarget')).slideDown(300);
    });
});
