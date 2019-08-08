<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Login')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="Lucas.F.Lu" />
</head>

<body class="usr_login_form" data-page="login">
    @fe_loginForm([
    'ajax'=>true,
    'linkType'=>'link',
    'linkText'=>'Login Here',
    'SignInTitle'=>'Please <strong>Sign</strong> In Here ...'
    ])
    Something Amazing is coming ...
    @endfe_loginForm
    @stack('fe_login_scripts')
</body>

</html>