<?php

namespace FeIron\Fe_Login\http\controllers;

use FeIron\Fe_Login\models\fe_users;
use FeIron\Fe_Login\resources\RouterParser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;


class FeSignupController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('Fe_Guest');
    }

    /**
     * Overriding registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('Fe_Login::LoginWindow',[
            'target' => 'register'
        ]);
    }

    /**
     * Overriding registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator= $this->validator($request->all());
        if($validator->fails()){
            return redirect()
                    ->back()
                    ->withInput($request->only('usr_name', 'email'))
                    ->with('target', 'register')
                    ->withErrors($validator);
        }

        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);
        $user->sendEmailVerificationNotification();
        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'usr_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'between:8,255', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return fe_users::create([
            'name' => $data['usr_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'provider_type' => 'Local',
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }
}
