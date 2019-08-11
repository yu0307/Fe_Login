<?php

namespace feiron\fe_login\http\controllers;

use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use TheSeer\Tokenizer\Exception;
use feiron\fe_login\models\fe_users;
use feiron\fe_login\resources\RouterParser;
use feiron\fe_login\lib\events\UserCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;


class FeLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    */
    use RouterParser;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new FeLoginController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('Fe_Guest')->except('logout');
    }

    public function index()
    {
        return $this->RenderLoginForm();
    }
    
    public function RenderLoginWindow(Request $request){
        return view('fe_login::LoginWindow')->with(['target' => $this->ParseTarget($request)]);
    }

    public function TryLogin($AuthType = null, Request $request){
        if (!isset($AuthType)) {
            return redirect()->route('fe_loginWindow');
        } else {
            $customMessages = [
                'email.required' => 'Email cannot be empty',
                'email.e_mail' => 'Not a valid email address',
                'password.required'  => 'Password is required',
            ];
            if($AuthType== 'webform'){
                $request->validate([
                    'email' => 'required|email',
                    'password' => 'required',
                ], $customMessages);
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials, ($request->rememberMe ?? false) )) {
                    Auth::user()->last_login = now();
                    Auth::user()->save();
                    return $request->ajax()?  ['status'=>'success','message' => 'Login Successfull']:redirect()->back();
                }else{
                    return $request->ajax() ? ['status' => 'error', 'message' => 'Login info is incorrect.'] : redirect()->back()->withErrors(['authentication' => 'Login info is incorrect.']);
                }
            }else{
                try {
                    config([('services.' . $AuthType) => config('fe_login.appconfig.DefaultLoginProviders.' . $AuthType)]);
                    return Socialite::driver($AuthType)->redirect();
                } catch (Exception $e) {
                    return 'Authentication Error' . (config('app.debug') === false ? '' : ('<br/>' . $e));
                }
            }
        }
        return false;
    }
    
    public function logout(){
        auth()->logout();
        return redirect(Route::has('home')?route('home'): (URL::to('/')));
    }

    public function handleProviderCallback($AuthType=null){
        if (!isset($AuthType)) {
            return redirect()->route('fe_loginWindow');
        } else {
            try {
                    config([('services.'.$AuthType)=>config('fe_login.appconfig.DefaultLoginProviders.'.$AuthType)]);
                    $user = Socialite::driver($AuthType)->user();
                    if(isset($user->email)){
                        $existingUser = fe_users::where('email', $user->email)->first();
                        if ($existingUser) {
                            $existingUser->last_login = now();
                            $existingUser->provider_id     = $user->id;
                            $existingUser->provider_type   = $AuthType;
                            $existingUser->save();
                            auth()->login($existingUser, true);
                        } else {
                            // create a new user
                            $newUser                  = new fe_users;
                            $newUser->name            = $user->name;
                            $newUser->email           = $user->email;
                            $newUser->provider_id     = $user->id;
                            $newUser->provider_type   = $AuthType;
                            $newUser->last_login      = now();
                            $newUser->password        = Hash::make(str_random(16));
                            $newUser->save();
                            event(new UserCreated($newUser));
                            auth()->login($newUser, true);
                            if (!$newUser->hasVerifiedEmail()) {
                                $newUser->sendEmailVerificationNotification();
                            }                        
                        }
                        return redirect()->back();
                    }else{
                        return redirect()->route('fe_loginWindow')->withErrors(['TwitterAuthError'=>"Account Email not found"]);
                    }
                    
                } catch (\Exception $e) {
                    if(config('app.debug')!==false){
                        dd($e);
                    }
                    return redirect()->route('fe_loginWindow')->withErrors(['authentication' => 'Authentication with third party failed.']);
                }
        }
        return false;
    }
}
