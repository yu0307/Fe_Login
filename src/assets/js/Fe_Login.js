$(document).ready(function(){
    $('.swap_ctrl').click(function(e){
        e.preventDefault();
        $('#fe_login-block .Fe_ctrl_windows').slideUp(300);
        $('#fe_login-block .' + $(this).attr('wintarget')).slideDown(300);
    });
});
