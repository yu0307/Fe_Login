@section('title', 'Login Window')
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
                        <div id="Fe_Login_container">
                            @if (config('fe_login_appconfig.HasFormLogin'))
                            <form class="form-signin" role="form" action="{{isset($FormAction)?$FormAction:route('Fe_LoginControl', ['AuthType' =>'webform'])}}">
                                <h3>{!! (isset($SignInTitle)?$SignInTitle:"<strong>Sign in</strong> to your account") !!} </h3>
                                <div class="append-icon m-b-20">
                                    <input type="text" name="username" aria-label="Username" aria-describedby="Fe_ctrl_usr" id="Fe_login_name" class="form-control form-white username" placeholder="Username" required>
                                    <i class="far fa-user-circle"></i>
                                </div>

                                <div class="append-icon m-b-20">
                                    <input type="password" name="password" class="form-control form-white password" placeholder="Password" required>
                                    <i class="fas fa-user-lock"></i>
                                </div>
                                <button type="submit" id="Fe_login_submit-form" class="btn btn-lg btn-dark btn-rounded ladda-button" data-style="expand-left">Sign In</button>
                                <div id="Fe_sub_controls" class="Fe_sub_controls">
                                    @if(config('fe_login_appconfig.HasRegister'))
                                    <div class="sub_trls">
                                        <a href="#" class="fe_btn_signup">Sign up</a>
                                    </div>
                                    @endif
                                    @if(config('fe_login_appconfig.HasForgotPassword'))
                                    <div class="sub_trls">
                                        <span class="forgot-password"><a id="Fe_login_password" href="#">Forgot password?</a></span>
                                    </div>
                                    @endif
                                </div>
                            </form>
                            @endif
                            @if (config('fe_login_appconfig.HasSocialSignin'))
                            <div class="form-footer" id="SocialSignIn">
                                <div class="social-btn">
                                    @foreach (config('fe_login_appconfig.DefaultLoginProviders') as $provider)
                                    <a href="{{route('Fe_LoginControl', ['AuthType' => $provider])}}"><img src="{{ asset('FeIron/Fe_Login/images/'.$provider.'.png') }}" alt="signInWith{{$provider}}"></a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        @if(config('fe_login_appconfig.HasForgotPassword'))
                        <form class="form-password" role="form" action="{{isset($FormAction_forgotPass)?$FormAction_forgotPass:route('Fe_PasswordReset')}}">
                            <h3>{!! isset($ResetTitle)?$ResetTitle:'<strong>Reset</strong> your password' !!}</h3>
                            <div class="append-icon m-b-20">
                                <input type="text" name="reset_email" class="form-control form-white" placeholder="Email" required>
                                <i class="fas fa-envelope"></i>
                            </div>
                            <button type="submit" id="Fe_login_submit_reset" class="btn btn-lg btn-info btn-block ladda-button" data-style="expand-left">Send Password Reset Link</button>
                            <div class="Fe_sub_controls m-t-60">
                                <div class="sub_trls">
                                    <a id="Fe_login" href="#">Have an account? Sign In</a>
                                </div>
                                <div class="sub_trls">
                                    @if(config('fe_login_appconfig.HasRegister'))
                                    <a href="#" class="fe_btn_signup">New here? Sign up</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                        @endif

                        @if(config('fe_login_appconfig.HasRegister'))
                        <form class="form-signup" role="form" action="{{isset($SignUpURL)?$SignUpURL:route('Fe_SignUp')}}">
                            <h3>{!! isset($SignUpTitle)?$SignUpTitle:'<strong>Create</strong> your account' !!}</h3>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="append-icon m-b-20">
                                        <input type="text" name="FirstName" class="form-control form-white" placeholder="First Name" required>
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="append-icon m-b-20">
                                        <input type="text" name="LastName" class="form-control form-white" placeholder="Last Name" required>
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="append-icon m-b-20">
                                        <input type="text" name="usr_email" class="form-control form-white" placeholder="Email" required>
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="append-icon m-b-20">
                                        <input type="text" name="usr_password" class="form-control form-white" placeholder="Password" required>
                                        <i class="fas fa-key"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="append-icon m-b-20">
                                        <input type="text" name="usr_password_cfm" class="form-control form-white" placeholder="Confirm Password" required>
                                        <i class="fas fa-key"></i>
                                    </div>
                                </div>
                            </div>
                            @if(config('fe_login_appconfig.HasTermURL'))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="fe_term_agreement">
                                        <label class="form-check-label" for="fe_term_agreement">
                                            I agree with the <a href="{{config('fe_login_appconfig.HasTermURL')}}">terms and conditions</a>.
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <hr>
                            <button type="submit" id="Fe_login_signup-form" class="btn btn-lg btn-dark btn-rounded ladda-button" data-style="expand-left">Sign up</button>

                            <div class="Fe_sub_controls m-t-60">
                                <div class="sub_trls">
                                    <a class="btn_signIn" href="#">Already have an account? Sign In</a>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('Fe_Login_public')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link href="{{asset('FeIron/Fe_Login/css/Fe_Login_ui.css')}}" rel="stylesheet">
@endpush

@push('Fe_Login_styles')
<link href="{{asset('FeIron/Fe_Login/css/Fe_Login.css')}}" rel="stylesheet">
<link href="{{asset('FeIron/Fe_Login/ThirdParty/fontawesome5.9.0/css/all.min.css')}}" rel="stylesheet">
@endpush

@push('Fe_Login_scripts')
<script src="{{asset('FeIron/Fe_Login/js/Fe_Login.js')}}"></script>
@endpush