<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
   public function sendResetLinkEmail(Request $request)
{
    $validatedData = $request->validate([
        'email' => 'required|email',
    ]);

    $response = $this->broker()->sendResetLink(
        $validatedData
    );

    return $response == Password::RESET_LINK_SENT
        ? response(['message' => 'Reset link sent to your email'])
        : response(['error' => 'Unable to send reset link'], 400);
}

}