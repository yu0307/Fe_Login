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

    private $customMessages;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('FeAuthenticate');
        $this->customMessages = [
            'email.required'    => 'Email cannot be empty',
            'email.e_mail'      => 'Not a valid email address',
            'email.unique'      => 'Email is already taken',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Passwords do not match',
            'usr_ID.numeric'    => 'User Identification Format Error.'
        ];
    }

    public function show(){
        return view('fe_login::LoginUsrManagerWindow');
    }

    public function loadList(Request $request, UserManagement $UserManager, $usrMeta=null, $withMyself=false){
        $usr=[];
        foreach($UserManager->getUsers($usrMeta ?? [], ($withMyself ?? false))as $User){
            $User= $User->toArray();
            $User['img'] = !empty($User['profile_image']) ? Storage::url($User['profile_image']) : ("https://www.gravatar.com/avatar/" . md5(strtolower(trim($User['email']))) . "?d=mp&s=60");
            array_push($usr,$User);
        }

        return response()->json($usr);
    }

    public function UpdateUser(Request $request){
        $me= fe_users::find(auth()->user()->id);
        $rules = [];
        $message= 'Information Updated.';
        if($request->has('password')){
            $request->validate(['password'=> 'required|confirmed|between:8,255|string'], $this->customMessages);
            $request->merge(['password'=>Hash::make($request->input('password'))]);
            unset($request['password_confirmation']);
            $message='Security Information Updated.';
        }else{
            $request->validate(['email'=> ('required|max:255|email|unique:users,email,' . $me->id . ',id')], $this->customMessages);
        }
        $me->update($request->except(['metainfo','user_timezone']));
        if ($request->filled('metainfo')) {
            foreach ($request->input('metainfo') as $key => $val) {
                $me->metainfo()->updateOrCreate(['meta_name' => $key], ['meta_value' => $val]);
            }
        }
        return response()->json(['status' => 'success', 'message' => $message]);
    }

    public function SaveUser(Request $request){
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
        $updates = [
            'email' => $request->input('email'),
            'name' => $request->input('usrName')
        ];
        $message = 'User Created';
        if ($request->filled('password')) {
            $updates['password'] = Hash::make($request->input('password'));
        }else{
            unset($request['password']);
            unset($request['password_confirmation']);
        }
        $request->validate($rules, $this->customMessages);

        if ($request->filled('usr_ID')){
            $usr=fe_users::find($request->input('usr_ID'));
            $usr->update($updates);
            $message = 'User Updated';
        }else{
            $updates['provider_type']='local';
            $usr=fe_users::create($updates);
        }

        if ($request->filled('metainfo')) {
            foreach ($request->input('metainfo') as $key => $val) {
                $val = is_array($val)?join(',',$val):$val;
                $usr->metainfo()->updateOrCreate(['meta_name' => $key],['meta_value' => $val]);
            }
        }
        

        return response()->json(['status' => 'success', 'message' => $message]);
    }

    public function GetUser(Request $request, $UID){
        return response()->json(fe_users::find($UID)->load('metainfo')->makeVisible('metainfo')->toArray()??[]);
    }

    public function RemoveUser(Request $request, $UID){
        fe_users::find($UID)->delete();
        return response()->json(['status' => 'success', 'message' => 'User removed.']);
    }

}
