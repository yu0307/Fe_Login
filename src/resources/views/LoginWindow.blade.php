<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Login')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="Lucas.F.Lu" />
    <style>
        body {
            height: 100%;
            background: #F5F5F5;
            color: #5B5B5B;
            font-family: 'Lato', 'Open Sans', Helvetica, sans-serif !important;
            line-height: 1.42857143;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            font-size: 14px;
        }
    </style>
</head>

<body class="usr_login_form" data-page="login">
    @fe_loginForm([
    'SignInTitle'=>'Please <strong>Sign</strong> In Here ...',
    'Slot'=>'Something Amazing is coming ...'
    ])
    @stack('fe_login_scripts')
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('#Fe_login-block').fadeIn(700, 'linear');
        });
    </script>
    <script src="{{asset('/feiron/fe_login/ThirdParty/backstretch/jquery.backstretch.min.js')}}"></script>
    <script src="{{asset('/feiron/fe_login/js/backstretch.js')}}"></script>
</body>

</html>