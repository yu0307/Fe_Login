<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Login')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="FeIron" name="Lucas.F.Lu" />
</head>

<body class="usr_login_form" data-page="login">
    @Fe_LoginForm([
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
</body>

</html>