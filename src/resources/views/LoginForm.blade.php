@section('title', 'Login Window')

@section('Fe_LoginWindow')
<div class="container" id="Fe_login-block">
    <i class="user-img icons-faces-users-03"></i>
    <div class="account-info">
        <a href="#" class="logo">@yield('Logo',config('app.name'))</a>
        <h3>@yield('FormTitle',config('app.name'))</h3>
        <div>
            @yield('FormNotification','')
        </div>
    </div>
    <div class="account-form">
        <h3>@yield('SignInTitle','Sign in to your account')</h3>
        @if (config('fe_login_appconfig.HasFormLogin'))
        <form class="form-signin" role="form" action="@yield('FormAction',route('Fe_LoginControl', ['AuthType' =>'webform']))">
            <div class="append-icon">
                <input type="text" name="username" id="Fe_login_name" class="form-control form-white username" placeholder="Username" required>
                <i class="icon-user"></i>
            </div>
            <div class="append-icon m-b-20">
                <input type="password" name="password" class="form-control form-white password" placeholder="Password" required>
                <i class="icon-lock"></i>
            </div>
            <button type="submit" id="Fe_login_submit-form" class="btn btn-lg btn-dark btn-rounded ladda-button" data-style="expand-left">Sign In</button>
            <div>
                @if(config('fe_login_appconfig.HasRegister'))
                <div class="clearfix">
                    <p class="new-here"><a href="@yield('SignUpURL',route('Fe_SignUp'))">New here? Sign up</a></p>
                </div>
                @endif
                @if(config('fe_login_appconfig.HasForgotPassword'))
                <span class="forgot-password"><a id="Fe_login_password" href="#">Forgot password?</a></span>
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
        @if(config('fe_login_appconfig.HasForgotPassword'))
        <form class="form-password" role="form" action="@yield('FormAction_forgotPass',route('Fe_PasswordReset'))">
            <h3>@yield('ResetTitle','<strong>Reset</strong> your password')</h3>
            <div class="append-icon m-b-20">
                <input type="text" name="reset_email" class="form-control form-white" placeholder="Email" required>
                <i class="icon-email"></i>
            </div>
            <button type="submit" id="Fe_login_submit_reset" class="btn btn-lg btn-info btn-block ladda-button" data-style="expand-left">Send Password Reset Link</button>
            <div class="clearfix m-t-60">
                <p class="pull-left m-t-20 m-b-0"><a id="Fe_login" href="#">Have an account? Sign In</a></p>
                @if(config('fe_login_appconfig.HasRegister'))
                <p class="pull-right m-t-20 m-b-0"><a href="@yield('SignUpURL',route('Fe_SignUp'))">New here? Sign up</a></p>
                @endif
            </div>
        </form>
        @endif
    </div>
</div>
@endsection

@push('Fe_styles')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link href="{{asset('FeIron/Fe_Login/css/Fe_Login.css')}}" rel="stylesheet">
<link href="{{asset('FeIron/Fe_Login/ThirdParty/font-awesome/font-awesome.min.css')}}" rel="stylesheet">
<link href="{{asset('FeIron/Fe_Login/css/Fe_Login_ui.css')}}" rel="stylesheet">
@endpush

@push('Fe_scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="{{asset('FeIron/Fe_Login/js/Fe_Login.js')}}"></script>
@endpush