<?php

namespace FeIron\Fe_Login\http\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $this->middleware('guest');
    }

    //Overriding validation rules
    protected function validateEmail(Request $request)
    {
        $validator = $this->validator($request->only('email'));
        if ($validator->fails()) {
            return redirect()
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
        return back()->with([
            'status' => trans($response),
            'target', 'getpassword'
            ]);
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
        return back()
            ->withInput($request->only('email'))
            ->with('target', 'getpassword')
            ->withErrors(['email' => trans($response)]);
    }
}
