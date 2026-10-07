<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected function sendResetLinkResponse(\Illuminate\Http\Request $request, $response)
    {
        return $request->wantsJson() || $request->ajax()
                    ? new \Illuminate\Http\JsonResponse(['success' => true, 'message' => trans($response)], 200)
                    : back()->with('status', trans($response));
    }

    protected function sendResetLinkFailedResponse(\Illuminate\Http\Request $request, $response)
    {
        if ($request->wantsJson() || $request->ajax()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
    }
}
