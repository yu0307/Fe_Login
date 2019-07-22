<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Login')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="FeIron" name="Lucas.F.Lu" />
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
    @Fe_LoginForm([
    'target'=>$target,
    'SignInTitle'=>'Please <strong>Sign</strong> In Here ...'
    ])
    Something Amazing is coming ...
    @endFe_LoginForm
    @stack('Fe_Login_scripts')
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('#Fe_login-block').fadeIn(700, 'linear');
        });
    </script>
    <script src="{{asset('FeIron/Fe_Login/ThirdParty/backstretch/jquery.backstretch.min.js')}}"></script>
    <script src="{{asset('FeIron/Fe_Login/js/backstretch.js')}}"></script>
</body>

</html>