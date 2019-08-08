<?php

namespace feiron\fe_login\http\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class FePasswordRetrieval extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use SendsPasswordResetEmails;

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

    /**
     * Overriding password reset form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showResetForm()
    {
        return view('fe_login::LoginWindow', [
            'target' => 'getpassword'
        ]);
    }

    //Overriding validation rules
    protected function validateEmail(Request $request)
    {
        $validator = $this->validator($request->only('email'));
        if ($validator->fails()) {
            return $request->ajax() ?  ['status' => 'error', 'message' => $validator->getMessageBag()->toArray()] : 
                    redirect()
                    ->back()
                    ->withInput($request->only('email'))
                    ->with('target', 'getpassword')
                    ->withErrors($validator);
        }
    }
    
    /**
     * Get a validator for an incoming password reset request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $customMessages = [
            'email.required' => 'Email cannot be empty',
            'email.e_mail' => 'Not a valid email address',
            'email.exists'  => 'No such user found',
        ];
        return Validator::make($data, ['email' => 'required|email|exists:users,email'], $customMessages);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return ($request->ajax() ?  ['status' => 'success', 'message' => 'Password reset link is sent.'] : back()->with([
            'message' => trans($response),
            'status'=>'success'
            ]));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return $request->ajax() ?  ['status' => 'error', 'message' => ['email' => trans($response)]] : 
            back()
            ->withInput($request->only('email'))
            ->with('target', 'getpassword')
            ->withErrors(['email' => trans($response)]);
    }
}
