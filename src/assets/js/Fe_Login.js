$(document).ready(function(){
    $('#Fe_login_password').on('click', function (e) {
        e.preventDefault();
        $('#Fe_login-block #Fe_Login_container').slideUp(300, function () {
            $('#Fe_login-block .form-password').slideDown(300);
        });
    });
    $('#Fe_login').on('click', function (e) {
        e.preventDefault();
        $('#Fe_login-block .form-password').slideUp(300, function () {
            $('#Fe_login-block #Fe_Login_container').slideDown(300);
        });
    });
    $('#Fe_Login_container .fe_btn_signup').on('click', function (e) {
        e.preventDefault();
        $('#Fe_login-block #Fe_Login_container').slideUp(300, function () {
            $('#Fe_login-block .form-signup').slideDown(300);
        });
    });
    $('.form-password .fe_btn_signup').on('click', function (e) {
        e.preventDefault();
        $('#Fe_login-block .form-password').slideUp(300, function () {
            $('#Fe_login-block .form-signup').slideDown(300);
        });
    });
    $('.form-signup .btn_signIn').on('click', function (e) {
        e.preventDefault();
        $('#Fe_login-block .form-signup').slideUp(300, function () {
            $('#Fe_login-block #Fe_Login_container').slideDown(300);
        });
    });
});
