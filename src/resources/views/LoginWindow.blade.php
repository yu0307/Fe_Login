<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title','Login')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="FeIron" name="Lucas.F.Lu" />
</head>

<body class="usr_login_form" data-page="login">
    @Fe_LoginForm
    @slot('SignInTitle')
    Please <strong>Sign</strong> In Here ...
    @endslot
    Choose the options from the right to login ...
    @endFe_LoginForm

    @stack('Fe_Login_public')
    @stack('Fe_Login_styles')
    @stack('Fe_Login_scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#Fe_login-block').fadeIn(700, 'linear');
        });
    </script>
</body>

</html>