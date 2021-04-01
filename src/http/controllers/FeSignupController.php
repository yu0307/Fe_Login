<?php

namespace feiron\fe_login\http\controllers;

use feiron\fe_login\models\fe_users;
use feiron\fe_login\resources\RouterParser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use feiron\fe_login\lib\events\UserCreated;


class FeSignupController extends Controller
{

    use RegistersUsers;
    
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('Fe_Guest');
    }

    public function showRegistrationForm()
    {
        return view('fe_login::LoginWindow',[
            'target' => 'register'
        ]);
    }

    public function register(Request $request)
    {
        $validator= $this->validator($request->all());
        if($validator->fails()){
            return $request->ajax() ?  ['status' => 'error', 'message' => $validator->getMessageBag()->toArray()] : 
                    redirect()
                    ->back()
                    ->withInput($request->only('usr_name', 'email'))
                    ->with('target', 'register')
                    ->withErrors($validator);
        }
        $user = $this->create($request->all());
        event(new UserCreated($user));
        $this->guard()->login($user);
        $user->sendEmailVerificationNotification();
        return $this->registered($request, $user)
                        ?: ($request->ajax() ?  ['status' => 'success', 'message' => 'Registration Successfull'] : redirect($this->redirectPath()));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'usr_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'between:8,255', 'confirmed']
        ]);
    }

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
