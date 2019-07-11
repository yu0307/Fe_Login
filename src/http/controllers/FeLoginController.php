<?php

namespace FeIron\Fe_Login\http\controllers;

use App\Http\Controllers\Controller;


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

    public function RenderLoginForm()
    {
        return view('Fe_Login::LoginForm');
    }

    public function RenderLoginWindow(){
        return view('Fe_Login::LoginWindow');
    }

    public function TryLogin($AuthType = null){
        if (!isset($AuthType)) {
            return redirect()->route('Fe_LoginWindow');
        } else {
            return 'waiting';
        }
    }

    // public function redirectToProvider()
    // {
    //     return Socialite::driver('google')->redirect();
    // }

    // public function logout()
    // {
    //     auth()->logout();
    //     return redirect('/');
    // }

    // public function handleProviderCallback()
    // {
    //     try {
    //         $user = Socialite::driver('google')->user();
    //     } catch (\Exception $e) {
    //         return redirect('/');
    //     }
    //     $existingUser = User::where('email', $user->email)->first();

    //     if ($existingUser) {
    //         // log them in
    //         auth()->login($existingUser, true);
    //     } else {
    //         // create a new user
    //         $newUser                  = new User;
    //         $newUser->name            = $user->name;
    //         $newUser->email           = $user->email;
    //         $newUser->google_id       = $user->id;
    //         $newUser->password        = Hash::make(str_random(16));
    //         // $newUser->avatar          = $user->avatar;
    //         // $newUser->avatar_original = $user->avatar_original;
    //         $newUser->save();
    //         auth()->login($newUser, true);
    //     }
    //     return redirect()->to('/');
    // }
}
