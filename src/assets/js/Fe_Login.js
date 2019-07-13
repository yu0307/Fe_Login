jQuery(document).ready(function(){
    jQuery('#Fe_login_password').on('click', function (e) {
        e.preventDefault();
        jQuery('#Fe_login-block #Fe_Login_container').slideUp(300, function () {
            jQuery('#Fe_login-block .form-password').slideDown(300);
        });
    });
    jQuery('#Fe_login').on('click', function (e) {
        e.preventDefault();
        jQuery('#Fe_login-block .form-password').slideUp(300, function () {
            jQuery('#Fe_login-block #Fe_Login_container').slideDown(300);
        });
    });
    jQuery('#Fe_Login_container .fe_btn_signup').on('click', function (e) {
        e.preventDefault();
        jQuery('#Fe_login-block #Fe_Login_container').slideUp(300, function () {
            jQuery('#Fe_login-block .form-signup').slideDown(300);
        });
    });
    jQuery('.form-password .fe_btn_signup').on('click', function (e) {
        e.preventDefault();
        jQuery('#Fe_login-block .form-password').slideUp(300, function () {
            jQuery('#Fe_login-block .form-signup').slideDown(300);
        });
    });
    jQuery('.form-signup .btn_signIn').on('click', function (e) {
        e.preventDefault();
        jQuery('#Fe_login-block .form-signup').slideUp(300, function () {
            jQuery('#Fe_login-block #Fe_Login_container').slideDown(300);
        });
    });
});
