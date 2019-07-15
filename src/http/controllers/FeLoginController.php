<?php

namespace FeIron\Fe_Login\http\controllers;

use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use TheSeer\Tokenizer\Exception;
use FeIron\Fe_Login\models\fe_users;
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
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return $this->RenderLoginForm();
    }
    
    public function RenderLoginWindow(){
        return view('Fe_Login::LoginWindow');
    }

    public function TryLogin($AuthType = null, Request $request){
        if (!isset($AuthType)) {
            return redirect()->route('Fe_LoginWindow');
        } else {
            $customMessages = [
                'email.required' => 'Email cannot be empty',
                'email.e_mail' => 'Not a valid email address',
                'password.required'  => 'Password is required',
            ];
            if($AuthType== 'webform'){
                $validatedData = $request->validate([
                    'email' => 'required|email',
                    'password' => 'required',
                ], $customMessages);
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {
                    Auth::user()->last_login = now();
                    Auth::user()->save();
                    return redirect()->back();
                }else{
                    // $request->session()->flash('error', 'Task was successful!');
                    return redirect()->back()->withErrors(['authentication' => 'Login info is incorrect.']);
                }
            }else{
                try {
                    config([('services.' . $AuthType) => config('Fe_Login.appconfig.DefaultLoginProviders.' . $AuthType)]);
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
            return redirect()->route('Fe_LoginWindow');
        } else {
            try {
                    config([('services.'.$AuthType)=>config('Fe_Login.appconfig.DefaultLoginProviders.'.$AuthType)]);
                    $user = Socialite::driver($AuthType)->user();
                    $existingUser = fe_users::where('email', $user->email)->first();
                    if ($existingUser) {
                        $existingUser->last_login=now();
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
                        auth()->login($newUser, true);
                    }
                    return redirect()->back();
                } catch (\Exception $e) {
                    if(config('app.debug')!==false){
                        dd($e);
                    }
                    return redirect()->route('Fe_LoginWindow')->withErrors(['authentication' => 'Authentication with third party failed.']);
                }
        }
        return false;
    }
}
