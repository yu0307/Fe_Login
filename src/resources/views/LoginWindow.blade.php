@include('Fe_Login::LoginForm')
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title','Login')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="FeIron" name="Lucas.F.Lu" />
    @stack('Fe_styles')
</head>

<body class="usr_login_form" data-page="login">
    @yield('Fe_LoginWindow')
    @stack('Fe_scripts')
</body>

</html>