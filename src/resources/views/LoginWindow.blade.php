@extends('fe_login::LoginFrame')

@php
$target=$target??(session('target')?? (app('request')->input('target')??null));
$ajax=(isset($ajax) && $ajax === true)|| config('fe_login.appconfig.useAjax');
@endphp

@section('title')
Login
@endsection

@push('headerstyles')
<link rel="stylesheet" href="{{asset('/feiron/fe_login/css/fe_LoginWindow.css')}}"/>
@endpush

@push('headerscripts')
<script type="text/javascript" src="{{asset('/feiron/fe_login/js/fe_LoginWindow.js')}}"></script>
@endpush

@section('social-icons')
<div class="form-social my-2" id="SocialSignIn">
    <div class="social-btn">
        @foreach (config('fe_login.appconfig.DefaultLoginProviders') as $provider=>$configs)
        <a href="{{route('fe_loginControl', ['AuthType' => $provider])}}"><img
                src="{{ asset('/feiron/fe_login/images/'.$provider.'.png') }}" alt="signInWith{{$provider}}"></a>
        @endforeach
        @if (config('fe_login.appconfig.useSSOAuth'))
        <a href="{{route('fe_SSOLogin')}}"><img
                src="{{ asset(config('fe_login.appconfig.useSSOAuth')['image']??('/feiron/fe_login/images/SSO.png')) }}"
                alt="Single Sign-On"></a>
        @endif
    </div>
</div>
@endsection

@section('main-content')
<div id="login_window">
    <div class="login py-5 p-3 position-absolute start-50 top-50 translate-middle {{($ajax??False)?'useAjax':''}} {{isset($target)?'right-panel-active':''}}">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-sm-12 ">
                    <div class="row h-100">


                        <div class="col-sm-6">
                            <div class="container-left h-100">
                                <div class="sign-in-container form-container">
                                    <div class="forms">
                                        <h4>{!! (isset($SignInTitle)?$SignInTitle:"Please <strong>Sign In</strong>
                                            here") !!}</h4>
                                        @if (config('fe_login.appconfig.HasFormLogin'))
                                        <form method="post" class="form-signin" role="form"
                                            action="{{isset($FormAction)?$FormAction:route('fe_loginControl', ['AuthType' =>'webform'])}}">
                                            @csrf
                                            <input name="email" type="email" placeholder="Email" required />
                                            <input name="password" type="password" placeholder="Password" required />
                                            @if(config('fe_login.appconfig.RememberLogin'))
                                            <div class="form-check form-switch my-3">
                                                <input class="form-check-input float-none" type="checkbox"
                                                    id="rememberLogin" name="rememberMe">
                                                <label class="form-check-label" for="rememberLogin">Remember Me</label>
                                            </div>
                                            @endif
                                            <div class="row w-100 mb-3">
                                                <div class="col-6 d-block d-sm-none">
                                                    @if(config('fe_login.appconfig.HasRegister'))
                                                    <a href="#" id="btn_signUp" class="btn_signUps btns">Sign Up</a>
                                                    @endif
                                                </div>
                                                <div class="col-6 col-sm-12">
                                                    <button id="btn_signIn btns" type="submit">Sign In</button>
                                                </div>
                                            </div>
                                            @if(config('fe_login.appconfig.HasForgotPassword'))
                                            <a href="#" id="btn_forgetPassword">Forgot your password?</a>
                                            @endif
                                            <div class="d-block d-sm-none mt-4">
                                                @if (config('fe_login.appconfig.HasSocialSignin') ||
                                                config('fe_login.appconfig.useSSOAuth'))
                                                @yield('social-icons')
                                                @endif
                                            </div>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="container-right h-100">

                                <div class="sign-up-container {{(($target=='register')?'':'d-none')}} form-container">
                                    <div class="forms">
                                        @if(config('fe_login.appconfig.HasRegister'))
                                        <form method="post" class="form-register Fe_ctrl_windows w-100" role="form"
                                            action="{{isset($SignUpURL)?$SignUpURL:route('Fe_SignUp')}}">
                                            @csrf
                                            <h5>{!! isset($SignUpTitle)?$SignUpTitle:'<strong>Create</strong> your account' !!}</h5>
                                            <input type="text" name="usr_name" class="form-control my-3" placeholder="Name ..." required value="{{ old('usr_name') }}">
                                            <input type="text" name="email" class="form-control my-3" placeholder="Email ..." required required value="{{ old('email') }}">
                                            <input type="password" name="password" class="form-control my-3" placeholder="Password ..." required>
                                            <input type="password" name="password_confirmation" class="form-control my-3" placeholder="Confirm Password ..." required>
                                            @if(config('fe_login.appconfig.HasTermURL'))
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="fe_term_agreement">
                                                        <label class="form-check-label" for="fe_term_agreement">
                                                            I agree with the <a href="{{config('fe_login.appconfig.HasTermURL')}}">terms and conditions</a>.
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <button type="submit" id="btn_signUp" class="mt-3">Sign Up</button>
                                            <a href="#" class="btn_signins d-block d-sm-none">
                                                <h6>Have an account? Sign In</h6>
                                            </a>
                                        </form>
                                        @endif
                                    </div>
                                </div>

                                <div class="forget-password {{(($target=='getpassword')?'':'d-none')}} form-container">
                                    <div class="forms">
                                        @if(config('fe_login.appconfig.HasForgotPassword'))
                                        <form method="post" class="form-password Fe_ctrl_windows w-100" role="form" action="{{isset($FormAction_forgotPass)?$FormAction_forgotPass:route('Fe_PasswordResetEmail')}}" >
                                            @csrf
                                            <h5>{!! isset($ResetTitle)?$ResetTitle:'<strong>Reset</strong> your password' !!}</h5>
                                            <input type="text" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}">
                                            <button id="btn_signUp" type="submit" class="mt-3">Get Password Reset Link</button>
                                            <a href="#" class="btn_signins d-block d-sm-none">
                                                <h6>Try Sign In Again</h6>
                                            </a>
                                        </form>
                                        @endif
                                    </div>
                                </div>

                                <div class="reset-password {{(($target=='reset')?'':'d-none')}} form-container">
                                    <div class="forms">
                                        @if(config('fe_login.appconfig.HasForgotPassword'))
                                        <form method="post" class="form-pswreset Fe_ctrl_windows w-100" role="form" action="{{isset($FormAction_resetURL)?$FormAction_resetURL:route('Fe_PasswordReset')}}">
                                            @csrf
                                            <h5>{!! isset($ResetTitle)?$ResetTitle:'<strong>Reset</strong> your password' !!}</h5>
                                            <input type="hidden" name="token" value="{{ (app('request')->input('token')??'') }}" required>
                                            <input type="hidden" name="email" value="{{ (app('request')->input('email') ?? '') }}" required>
                                            <input type="password" name="password" class="form-control my-3" placeholder="Password ..." required>
                                            <input type="password" name="password_confirmation" class="form-control my-3" placeholder="Confirm Password ..." required>
                                            <button type="submit" id="Fe_login_submit_reset" class="my-3">Reset My Password</button>
                                            <a href="#" class="btn_signins d-block d-sm-none">
                                                <h6>Try Sign In Again</h6>
                                            </a>
                                        </form>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="overlay-container">
                        <div class="overlay">
                            <div class="overlay-panel overlay-left">
                                <h2 href="/" class="logo">
                                    {!!$Logo??config('fe_login.appconfig.loginLogo')??config('app.name')!!}</h2>
                                <hr>
                                <button class="ghost btn_signins" id="btn_backSignIn">Try Sign In Again</button>
                            </div>
                            <div class="overlay-panel overlay-right">
                                <h2 href="/" class="logo">
                                    {!!$Logo??config('fe_login.appconfig.loginLogo')??config('app.name')!!}</a>
                                    <h3>{!!config('fe_login.appconfig.loginTitle')??$FormTitle??config('app.name')!!}
                                    </h3>
                                    <p>
                                        {!!config('fe_login.appconfig.loginDescription')??$Slot??''!!}
                                    </p>
                                    @if(config('fe_login.appconfig.HasRegister'))
                                    <button class="ghost btn_signUps" id="btn_trySignUp">Sign Up</button>
                                    @endif
                                    <hr>
                                    @if (config('fe_login.appconfig.HasSocialSignin') ||
                                    config('fe_login.appconfig.useSSOAuth'))
                                    <h6>Sign in with social accounts</h6>
                                    @yield('social-icons')
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center start-50 text-center translate-middle position-absolute" id="info_Section">
        <div class="w-50 details animate__animated animate__fadeInDown">
            @if ($errors->any())
            <div class="alert alert-danger info p-2">
                <ul class="m-0 p-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if(session('status'))
            <div class="alert alert-{{session('status')}} info general">
                {{session('message')}}
            </div>
            @endif
        </div>
    </div>
</div>
@parent
@endsection