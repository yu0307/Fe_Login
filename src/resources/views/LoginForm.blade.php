<div class="container" id="Fe_login-block" style="display:none">
    <div class="row justify-content-md-center">
        <div class="col-md-auto col-md-7 col-sm-12">
            <i class="far fa-id-badge fa-5x user-img"></i>
            <div class="row" id="Fe_login_area">
                <div class="col-md-5 col-sm-0 col">
                    <div class="account-info">
                        <a href="#" class="logo">{{isset($Logo)?$Logo:config('app.name')}}</a>
                        <h3>{{isset($FormTitle)?$FormTitle:config('app.name')}}</h3>
                        <div>
                            {{isset($slot)?$slot:''}}
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-sm-12 col">
                    <div class="account-form">
                        <div class="form-login Fe_ctrl_windows" id="Fe_Login_container" style="display:{{ ( (app('request')->has('target') || session('target') )?'none':'block') }}">
                            @if (config('Fe_Login.appconfig.HasFormLogin'))
                            <form class="form-signin" role="form" action="{{isset($FormAction)?$FormAction:route('Fe_LoginControl', ['AuthType' =>'webform'])}}">
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
                                <button type="submit" id="Fe_login_submit-form" class="btn btn-lg btn-dark btn-rounded ladda-button" data-style="expand-left">Sign In</button>
                                <div id="Fe_sub_controls" class="Fe_sub_controls">
                                    @if(config('Fe_Login.appconfig.HasRegister'))
                                    <div class="sub_trls">
                                        <a href="#" class="fe_btn_signup swap_ctrl" wintarget="form-signup">Sign up</a>
                                    </div>
                                    @endif
                                    @if(config('Fe_Login.appconfig.HasForgotPassword'))
                                    <div class="sub_trls">
                                        <span class="forgot-password"><a id="Fe_login_password" href="#" class="swap_ctrl" wintarget="form-password">Forgot password?</a></span>
                                    </div>
                                    @endif
                                </div>
                            </form>
                            @endif
                            @if (config('Fe_Login.appconfig.HasSocialSignin'))
                            <div class="form-footer" id="SocialSignIn">
                                <div class="social-btn">
                                    @foreach (config('Fe_Login.appconfig.DefaultLoginProviders') as $provider=>$configs)
                                    <a href="{{route('Fe_LoginControl', ['AuthType' => $provider])}}"><img src="{{ asset('FeIron/Fe_Login/images/'.$provider.'.png') }}" alt="signInWith{{$provider}}"></a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        @if(config('Fe_Login.appconfig.HasForgotPassword'))
                        <form class="form-password Fe_ctrl_windows" role="form" action="{{isset($FormAction_forgotPass)?$FormAction_forgotPass:route('Fe_PasswordResetEmail')}}" style="display:{{ 
                            ( 
                                (   session('target')=='getpassword' 
                                    || 
                                    (
                                        app('request')->has('target') 
                                        && 
                                        app('request')->input('target')=='getpassword'
                                    )
                                )?'block':'none'
                            ) }}">
                            @csrf
                            <h3>{!! isset($ResetTitle)?$ResetTitle:'<strong>Reset</strong> your password' !!}</h3>
                            <div class="append-icon m-b-20">
                                <input type="text" name="email" class="form-control form-white" placeholder="Email" required value="{{ old('email') }}">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <button type="submit" id="Fe_login_send_reset" class="btn btn-lg btn-info btn-block ladda-button" data-style="expand-left">Send Password Reset Link</button>
                            <div class="Fe_sub_controls m-t-60">
                                <div class="sub_trls">
                                    <a id="Fe_login" href="#" class="swap_ctrl" wintarget="form-login">Have an account? Sign In</a>
                                </div>
                                <div class="sub_trls">
                                    @if(config('Fe_Login.appconfig.HasRegister'))
                                    <a href="#" class="fe_btn_signup swap_ctrl" wintarget="form-signup">New here? Sign up</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                        @endif

                        @if(config('Fe_Login.appconfig.HasRegister'))
                        <form class="form-signup Fe_ctrl_windows" role="form" action="{{isset($SignUpURL)?$SignUpURL:route('Fe_SignUp')}}" style="display:{{ 
                            ( 
                                (
                                    session('target')=='register' 
                                    || 
                                    (
                                        app('request')->has('target') 
                                        && 
                                        app('request')->input('target')=='register'
                                    )
                                ) ?'block':'none'
                            ) }}">
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
                            @if(config('Fe_Login.appconfig.HasTermURL'))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="fe_term_agreement">
                                        <label class="form-check-label" for="fe_term_agreement">
                                            I agree with the <a href="{{config('Fe_Login.appconfig.HasTermURL')}}">terms and conditions</a>.
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <hr>
                            <button type="submit" id="Fe_login_signup-form" class="btn btn-lg btn-dark btn-rounded ladda-button" data-style="expand-left">Sign up</button>

                            <div class="Fe_sub_controls m-t-60">
                                <div class="sub_trls">
                                    <a class="btn_signIn swap_ctrl" href="#" wintarget="form-login">Already have an account? Sign In</a>
                                </div>
                            </div>
                        </form>
                        @endif

                        <form class="form-pswreset Fe_ctrl_windows" role="form" action="{{isset($FormAction_resetURL)?$FormAction_resetURL:route('Fe_PasswordReset')}}" style="display:{{ 
                            ( 
                                (   session('target')=='reset' 
                                    || 
                                    (
                                        app('request')->has('target') 
                                        && 
                                        app('request')->input('target')=='reset'
                                    )
                                )?'block':'none'
                            ) }}">
                            @csrf
                            <h3>{!! isset($ResetTitle)?$ResetTitle:'<strong>Reset</strong> your password' !!}</h3>
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
                            <button type="submit" id="Fe_login_submit_reset" class="btn btn-lg btn-info btn-block ladda-button" data-style="expand-left">Reset My Password</button>
                            <div class="Fe_sub_controls m-t-60">
                                <div class="sub_trls">
                                    <a id="Fe_login" href="#" class="swap_ctrl" wintarget="form-login">Have an account? Sign In</a>
                                </div>
                                <div class="sub_trls">
                                    @if(config('Fe_Login.appconfig.HasRegister'))
                                    <a href="#" class="fe_btn_signup swap_ctrl" wintarget="form-signup">New here? Sign up</a>
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
        <div class="col col-md-auto col-md-7 col-sm-12">
            @if ($errors->any())
            <div class="alert alert-danger info">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>

@section('title', 'Login Window')

@push('Fe_Login_scripts')
@if (file_exists(public_path('css/app.css')))
<link rel="stylesheet" href="{{asset('css/app.css')}}">
@endif

@if (file_exists(public_path('js/app.js')))
<script src="{{asset('js/app.js')}}"></script>
@else
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.1.min.js" crossorigin="anonymous"></script>
@endif
<link rel="stylesheet" href="{{asset('FeIron/Fe_Login/css/Fe_Login_ui.css')}}">
<script src="{{asset('FeIron/Fe_Login/js/Fe_Login_bootstrap.js')}}"></script>
<script src="{{asset('FeIron/Fe_Login/js/Fe_Login.js')}}"></script>
@endpush