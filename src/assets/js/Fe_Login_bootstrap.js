var head = document.head;
if (!window.$) {
    window.$ = window.jQuery; 
}
$(document).ready(function(){
    if (typeof ($.fn.modal) === 'undefined') {
        var script = document.createElement('script');
        script.type = "text/javascript";
        script.src = "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js";
        script.crossOrigin = "anonymous";
        script.integrity = "sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM";
        head.appendChild(script);
        var style = document.createElement('link');
        style.rel = "stylesheet";
        style.href = "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css";
        style.crossOrigin = "anonymous";
        style.integrity = "sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T";
        head.appendChild(style);
    }
    if (jQuery('link[href*="fontawesome"]').length <= 0) {
        var style = document.createElement('link');
        style.rel = "stylesheet";
        style.href = '/feiron/fe_login/ThirdParty/fontawesome5.9.0/css/all.min.css';
        head.appendChild(style);
    }
});