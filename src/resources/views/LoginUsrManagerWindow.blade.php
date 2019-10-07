<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','User Manager')</title>
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


<body class="usr_login_form p-5" data-page="login">
    <div class="row">
        <div class="col-md-2 d-none d-md-block">
        </div>
        <div class="col-md-8 col-sm-12">
        @fe_UserManager()
        @endfe_UserManager
        </div>
        <div class="col-md-2 d-none d-md-block">
        </div>
    </div>
    @stack('fe_login_scripts')
</body>

</html>