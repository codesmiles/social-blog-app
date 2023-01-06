<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Providers\UserFunctionServiceProvider;

class AuthController extends Controller
{

//! learn to use services file to handle repetitive code
// 1. create a service file
// 2. create a function to handle the repetitive code
// 3. call the function in the controller
// laravel generate a file to keep the repetitive code

// read more laravel documentation


    
    //-------------------------- REGISTER--------------------------------
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required',

        ]);

        // user validation
        Validator::make(request()->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'name' => 'required',
            'phone' => 'required',

        ]);
//  Model, associated array
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]
        $user = User::create($data);

        $token = $user->createToken('auth_token')->plainTextToken;
        $response = [
            'user' => $user,
            'message' => 'User created',
            'token' => $token

        ];
        return response($response, 201);
    }

    //--------------------- LOGIN-----------------------
    public function login(request $request)
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required_with:password|same:password|min:6',
            // check if the user is logged in
            // 'is_logged_in' => 'required|boolean|in:0,1|same:is_logged_in',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // return is_logged_in to true
        $user = User::where('email', $request->email)->first();
        if ($user->is_logged_in == true) {
            return response()->json([
                'message' => 'User already logged in'
            ], 409);
        }

        // loggin users in
        $user->is_logged_in = true;
        $user->save();
        // sanctum token        
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Logged in',
            'token' => $token
        ], 200);

    }
    //    -----------------------------LOGOUT USER -----------------------------------------
    public function logout(request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        // loggin users out
        $user->is_logged_in = false;
        $user->save();
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out',
        ], 200);

    }
}
