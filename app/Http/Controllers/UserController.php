<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Psy\Util\Json;


// store
// create
// index
// show
// update
// destroy


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            "message" => "Welcome to the blog API",
            // "update" =>"what's up"

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required',

        ]);

        // user validation
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'name' => 'required',
            'phone' => 'required',

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // $token = $user->createToken('auth_token')->plainTextToken;
        $response = [
            'user' => $user,
            'message' => 'User created',
            // 'token' => $token

        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    public function profile(Request $request){
        $user = User::where('id', auth()->user()->id)->first();
        return response()->json([
            "message" => "successful",
            "user" => $user
        ], 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|min:3',
        ]);

        $user = User::where('name', $request->name)->first();
        if (!$user) {
            return response()->json([
                "message" => "User not found",
            ], 400);
        }

        $self = User::where('name', auth()->user()->name)->first();
        if ($user == $self) {
            return response()->json([
                "message" => "Cannot search for self"
            ], 400);
        }

        return response()->json([
            "message" => "successful",
            "user" => [
                "name" => $user->name,
                "email" => $user->email,
                "phone" => $user->phone
            ],
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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