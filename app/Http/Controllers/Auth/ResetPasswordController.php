<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
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

    use ResetsPasswords;

    protected function sendResetResponse(\Illuminate\Http\Request $request, $response)
    {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => trans($response), 'ruta' => $this->redirectPath()]);
        }

        return redirect($this->redirectPath())
                            ->with('status', trans($response));
    }

    protected function sendResetFailedResponse(\Illuminate\Http\Request $request, $response)
    {
        if ($request->wantsJson() || $request->ajax()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';
}
