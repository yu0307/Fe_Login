<?php

namespace feiron\fe_login\http\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use feiron\fe_login\resources\notification\PasswordResetNotification;

class FePasswordReset extends Controller
{
    
    use ResetsPasswords;
    /**
     * Where to redirect users after resetting their password.
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

    public function showWindow(Request $request, $token,$email){
        if(null==$this->broker()->getUser(['email' => $email, 'token' => $token]) || !$this->broker()->getRepository()->exists($this->broker()->getUser(['email'=> $email,'token'=>$token]), $token)){
            return redirect()
                ->route('fe_loginWindow')
                ->withErrors(['InvalidToken'=>'Invalid Password Reset Link.']);
        }
        $validator = $this->validator(['token'=>$token, 'email'=>$email], true);
        if ($validator->fails()) {
            return redirect()
                ->route('fe_loginWindow')
                ->withInput($request->only('email'))
                ->with('target', 'getpassword')
                ->withErrors($validator);
        }
        $request->request->add(['token' => $token,'email'=>$email]);
        return view('fe_login::LoginWindow')->with(['target'=> 'reset']);
    }

    /**
     * Get a validator for an incoming password reset request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $entry_check = false){
        $customMessages = [
            'email.required' => 'Email cannot be empty',
            'email.e_mail' => 'Not a valid email address',
            'email.exists'  => 'No such user found',
            'token.required'  => 'Reset link expired',
            'password.between' => 'Password should be 8 to 255 characters long',
            'password.confirmed' => 'Passwords do not match'
        ];

        if($entry_check){
            return Validator::make($data, [
                'token' => 'required', 
                'email' => 'required|email|exists:password_resets,email', 
                'password' => ['required', 'string', 'between:8,255', 'confirmed']
            ], $customMessages);
        }else{
            return Validator::make($data, ['email' => 'required|email|exists:users,email'], $customMessages);
        }
        return false;
    }

    /**
     * Override Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function passreset(Request $request)
    {
        $validator = $this->validator($request->only(['token','email','password','password_confirmation']), true);
        if ($validator->fails()) {
            if($request->ajax()){
                return ['status' => 'error', 'message' => $validator->getMessageBag()->toArray()];
            }
            return redirect()
                ->route('fe_loginWindow', $request->only(['token', 'email']))
                ->with('target', 'reset')
                ->withErrors($validator);
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
                Notification::send($user, new PasswordResetNotification());
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if($request->ajax()){
            return ($response == Password::PASSWORD_RESET)
                    ?['status' => 'success', 'message' => 'Password reset successful']
                    :['status' => 'error', 'message' => trans($response)];
        }
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);        
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->only(['email','token']))
            ->withErrors(['email' => trans($response)]);
    }
}
