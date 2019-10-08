<?php

namespace feiron\fe_login\http\controllers;

use App\Http\Controllers\Controller;
use feiron\fe_login\models\fe_users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use feiron\fe_login\lib\UserManagement;
class FeUsrManagement extends Controller
{
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
        $this->middleware('FeAuthenticate');
    }

    public function show(){
        return view('fe_login::LoginUsrManagerWindow');
    }

    public function loadList(Request $request, UserManagement $UserManager, $usrMeta=null, $withMyself=false){
        $usr=[];
        foreach($UserManager->getUsers($usrMeta ?? [], ($withMyself ?? false))as $User){
            $User['img']=asset('feiron/fe_login/images/avatar_notif.png');
            array_push($usr,$User);
        }

        return response()->json($usr);
    }

    public function SaveUser(Request $request){
        $customMessages = [
            'email.required'    => 'Email cannot be empty',
            'email.e_mail'      => 'Not a valid email address',
            'email.unique'      => 'Email is already taken',
            'password.required' => 'Password is required',
            'password.confirmed'=> 'Passwords do not match',
            'usr_ID.numeric'    =>'User Identification Format Error.'
        ];
        $rules=[];
        $usr = null;
        if ($request->filled('usr_ID')) {
            $rules=[
                'email' => 'required|max:255|email|unique:users,email,' . $request->input('usr_ID') . ',id',
                'password' => 'sometimes|confirmed|between:8,255|string',
                'usr_ID'=> 'numeric'
            ];
        }else{
            $rules = [
                'email' => 'required|max:255|email|unique:users,email',
                'password' => 'required|confirmed|between:8,255|string',
            ];
        }
        $request->validate($rules, $customMessages);
        $updates = [
            'email' =>$request->input('email'),
            'name' => $request->input('usrName')
        ];
        $message='User Created';
        if ($request->filled('password')){
            $updates['password']= Hash::make($request->input('password'));
        }
        
        if ($request->filled('usr_ID')){
            $usr=fe_users::find($request->input('usr_ID'))->update($updates);
            $message = 'User Updated';
        }else{
            $updates['provider_type']='local';
            $usr=fe_users::create($updates);
        }

        return response()->json(['status' => 'success', 'message' => $message]);
    }

}
