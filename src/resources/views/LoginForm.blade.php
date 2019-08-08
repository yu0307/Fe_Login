@push('fe_login_scripts')
@if (file_exists(public_path('css/app.css')))
<link rel="stylesheet" href="{{asset('css/app.css')}}">
@endif

@if (file_exists(public_path('js/app.js')))
<script src="{{asset('js/app.js')}}"></script>
@else
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.1.min.js" crossorigin="anonymous"></script>
@endif
<link rel="stylesheet" href="{{asset('/feiron/fe_login/css/fe_login_ui.css')}}">
<script src="{{asset('/feiron/fe_login/js/fe_login_bootstrap.js')}}"></script>
<script src="{{asset('/feiron/fe_login/js/fe_login.js')}}"></script>
@endpush

@php
//This approach is not seperating controllers away from views. anyone with better ways to pass in this target var is welcomed to contribute.
//Drop me a line and we get this improved.

$target=$target??(session('target')?? (app('request')->input('target')??null));
$ajax=(isset($ajax) && $ajax === true);
@endphp

@if($ajax)
@section('LoginForm')
@endif
<div class="container" id="Fe_login-block" style="display:{{$ajax?'block':'none'}}">
    <div class="row justify-content-md-center">
        <div class=" {{$ajax?'w-75 mw-100':'col-md-auto col-md-7 col-sm-12 col-12'}}">
            {!! $ajax?'':'<i class="far fa-id-badge fa-5x user-img"></i>' !!}
            <div class="row" id="Fe_login_area">
                <div class="col-md-5 d-none d-sm-none d-md-block  col">
                    <div class="account-info">
                        <a href="/" class="logo">{{isset($Logo)?$Logo:config('app.name')}}</a>
                        <h3>{{isset($FormTitle)?$FormTitle:config('app.name')}}</h3>
                        <div>
                            {{isset($Slot)?$Slot:''}}
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-sm-12 col-12 col">
                    <div class="account-form">
                        <div class="form-login Fe_ctrl_windows" id="fe_login_container" style="display:{{ ( isset($target)?'none':'block') }}">
                            @if (config('fe_login.appconfig.HasFormLogin'))
                            <form method="post" class="form-signin" role="form" action="{{isset($FormAction)?$FormAction:route('fe_loginControl', ['AuthType' =>'webform'])}}">
                                @csrf
                                <h3>{!! (isset($SignInTitle)?$SignInTitle:"<strong>Sign in</strong> to your account") !!} </h3>
                                <div class="append-icon m-b-20">
                                    <input type="text" name="email" aria-label="email" aria-describedby="Fe_ctrl_usr" id="Fe_login_name" class="form-control form-white username" placeholder="Email ..." required>
                                    <i class="far fa-user-circle"></i>
                                </div>

                                <div class="append-icon m-b-20">
                                    <input type="password" name="password" class="form-control form-white password" placeholder="Password" required>
                                    <i class="fas fa-user-lock"></i>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-12">
                                        <button type="submit" id="Fe_login_submit-form" class="btn btn-lg btn-dark btn-rounded ladda-button col-sm-12 col-12" data-style="expand-left">Sign In</button>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-12 p-2 text-center">
                                        @if(config('fe_login.appconfig.RememberLogin'))
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="true" id="fe_login_remember" name="rememberMe">
                                            <label class="form-check-label" for="fe_login_remember">
                                                Remember Me
                                            </label>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div id="Fe_sub_controls" class="Fe_sub_controls">
                                    @if(config('fe_login.appconfig.HasRegister'))
                                    <div class="sub_trls">
                                        <a href="#" class="fe_btn_signup swap_ctrl" wintarget="form-register">Sign up</a>
                                    </div>
                                    @endif
                                    @if(config('fe_login.appconfig.HasForgotPassword'))
                                    <div class="sub_trls">
                                        <span class="forgot-password"><a id="Fe_login_password" href="#" class="swap_ctrl" wintarget="form-password">Forgot password?</a></span>
                                    </div>
                                    @endif
                                </div>
                            </form>
                            @endif
                            @if (config('fe_login.appconfig.HasSocialSignin'))
                            <div class="form-footer" id="SocialSignIn">
                                <div class="social-btn">
                                    @foreach (config('fe_login.appconfig.DefaultLoginProviders') as $provider=>$configs)
                                    <a href="{{route('fe_loginControl', ['AuthType' => $provider])}}"><img src="{{ asset('/feiron/fe_login/images/'.$provider.'.png') }}" alt="signInWith{{$provider}}"></a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        @if(config('fe_login.appconfig.HasForgotPassword'))
                        <form method="post" class="form-password Fe_ctrl_windows" role="form" action="{{isset($FormAction_forgotPass)?$FormAction_forgotPass:route('Fe_PasswordResetEmail')}}" style="display:{{ (($target=='getpassword')?'block':'none') }}">
                            @csrf
                            <h3>{!! isset($ResetTitle)?$ResetTitle:'<strong>Reset</strong> your password' !!}</h3>
                            <div class="append-icon m-b-20">
                                <input type="text" name="email" class="form-control form-white" placeholder="Email" required value="{{ old('email') }}">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <button type="submit" id="Fe_login_send_reset" class="btn btn-lg btn-dark btn-rounded ladda-button col-sm-12 col-12" data-style="expand-left">Send Password Reset Link</button>
                            <div class="Fe_sub_controls m-t-60">
                                <div class="sub_trls">
                                    <a href="#" class="swap_ctrl" wintarget="form-login">Have an account? Sign In</a>
                                </div>
                                <div class="sub_trls">
                                    @if(config('fe_login.appconfig.HasRegister'))
                                    <a href="#" class="swap_ctrl" wintarget="form-register">New here? Sign up</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                        @endif

                        @if(config('fe_login.appconfig.HasRegister'))
                        <form method="post" class="form-register Fe_ctrl_windows" role="form" action="{{isset($SignUpURL)?$SignUpURL:route('Fe_SignUp')}}" style="display:{{ (($target=='register')?'block':'none')}}">
                            @csrf
                            <h3>{!! isset($SignUpTitle)?$SignUpTitle:'<strong>Create</strong> your account' !!}</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="append-icon m-b-20">
                                        <input type="text" name="usr_name" class="form-control form-white" placeholder="Name ..." required value="{{ old('usr_name') }}">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="append-icon m-b-20">
                                        <input type="text" name="email" class="form-control form-white" placeholder="Email ..." required required value="{{ old('email') }}">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="append-icon m-b-20">
                                        <input type="password" name="password" class="form-control form-white" placeholder="Password ..." required>
                                        <i class="fas fa-key"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="append-icon m-b-20">
                                        <input type="password" name="password_confirmation" class="form-control form-white" placeholder="Confirm Password ..." required>
                                        <i class="fas fa-key"></i>
                                    </div>
                                </div>
                            </div>
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
                            <hr>
                            <button type="submit" id="Fe_login_signup-form" class="btn btn-lg btn-dark btn-rounded ladda-button col-sm-12 col-12" data-style="expand-left">Sign up</button>

                            <div class="Fe_sub_controls m-t-60">
                                <div class="sub_trls">
                                    <a class="btn_signIn swap_ctrl" href="#" wintarget="form-login">Already have an account? Sign In</a>
                                </div>
                            </div>
                        </form>
                        @endif

                        <form method="post" class="form-pswreset Fe_ctrl_windows" role="form" action="{{isset($FormAction_resetURL)?$FormAction_resetURL:route('Fe_PasswordReset')}}" style="display:{{ (($target=='reset')?'block':'none')}}">
                            @csrf
                            <h3>{!! isset($ResetTitle)?$ResetTitle:'<strong>Reset</strong> your password' !!}</h3>
                            <input type="hidden" name="token" value="{{ (app('request')->input('token')??'') }}" required>
                            <input type="hidden" name="email" value="{{ (app('request')->input('email') ?? '') }}" required>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="append-icon m-b-20">
                                        <input type="password" name="password" class="form-control form-white" placeholder="Password ..." required>
                                        <i class="fas fa-key"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="append-icon m-b-20">
                                        <input type="password" name="password_confirmation" class="form-control form-white" placeholder="Confirm Password ..." required>
                                        <i class="fas fa-key"></i>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" id="Fe_login_submit_reset" class="btn btn-lg btn-dark btn-rounded ladda-button col-sm-12 col-12" data-style="expand-left">Reset My Password</button>
                            <div class="Fe_sub_controls m-t-60">
                                <div class="sub_trls">
                                    <a id="Fe_login" href="#" class="swap_ctrl" wintarget="form-login">Have an account? Sign In</a>
                                </div>
                                <div class="sub_trls">
                                    @if(config('fe_login.appconfig.HasRegister'))
                                    <a href="#" class="fe_btn_signup swap_ctrl" wintarget="form-register">New here? Sign up</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center" id="info_Section">
        <div class="col col-md-auto col-md-7 col-sm-12 col-12">
            @if ($errors->any())
            <div class="alert alert-danger info">
                <ul>
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
@if ($ajax)
@endsection
@include('fe_login::ModalFrame')
@endif


@section('title', 'Login Window')