<?php

namespace FeIron\Fe_Login\http\controllers;

use App\Http\Controllers\Controller;
use Socialite;
use TheSeer\Tokenizer\Exception;
use FeIron\Fe_Login\models\fe_users;
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
    // protected $redirectTo = '/';

    /**
     * Create a new FeLoginController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return $this->RenderLoginForm();
    }
    
    public function RenderLoginWindow(){
        return view('Fe_Login::LoginWindow');
    }
    
    public function TryLogin($AuthType = null){
        if (!isset($AuthType)) {
            return redirect()->route('Fe_LoginWindow');
        } else {
            try {
                    config([('services.'.$AuthType)=>config('Fe_Login.appconfig.DefaultLoginProviders.'.$AuthType)]);
                    return Socialite::driver($AuthType)->redirect();
                } catch (Exception $e) {
                    return 'Authentication Error'.(config('app.debug')===false?'':('<br/>'.$e));
                }
        }
        return false;
    }
    
    public function logout()
    {
        auth()->logout();
        return redirect(Route::has('home')?route('home'): (URL::to('/')));
    }

    public function handleProviderCallback($AuthType=null)
    {
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
                    return redirect(Route::has('home') ? route('home') : (URL::to('/')));
                } catch (\Exception $e) {
                    if(config('app.debug')!==false){
                        dd($e);
                    }
                    return redirect()->route('Fe_LoginWindow');
                }
        }
        return false;
    }
}
