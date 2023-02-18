<?php
namespace App\Repository;

use App\Events\UserCreated;
use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\AuthException;

class AuthRepository implements AuthInterface
{
    public function register(array $request)
    {
        // return User::create($request);
        $newUser = User::create($request);
        throw_if(!$newUser,AuthException::class, "User not created", Response::HTTP_INTERNAL_SERVER_ERROR);

        // Firing an event for creating users
        event(new UserCreated($newUser));

        return $newUser;

    }

    public function login( $request)
    {
        
        $credentials = $request->only('email', 'password');

        throw_if(!Auth::attempt($credentials), AuthException::class, "Invalid Credentials", Response::HTTP_UNPROCESSABLE_ENTITY);

        return [
            'message' => 'User logged in',
            "token" => Auth::user()->createToken('auth_token')->plainTextToken,
        ];
    }

    public function logout()
    {
        // throw_if(!Auth::user(), AuthException::class, "User not logged in", Response::HTTP_UNAUTHORIZED);
        return Auth::user()->tokens()->delete();
    }

}
