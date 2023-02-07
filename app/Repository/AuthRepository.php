<?php
namespace App\Repository;

use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthInterface
{
    public function register($request)
    {
        return User::create($request);
    }

    public function login($request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNPROCESSABLE_ENTITY); //422

        }
        return [
            'message' => 'User logged in',
            "token" => Auth::user()->createToken('auth_token')->plainTextToken,
        ];

    }

    public function logout()
    {
        return Auth::user()->tokens()->delete();
    }

}
