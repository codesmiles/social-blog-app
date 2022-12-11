<?php

namespace App\Http\Controllers;

use App\Models\User;
use illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function home(){
        // return response()->json([
        //     "message" => "Welcome to the blog API",
        //     // "update" =>"what's up"
        // ]);
    }

    public function signup(Request $request)
    {
        // $validateData = $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'phone'=>'required',
        //     'password' => 'required',
        //     ]);
            
        //     // check if user already exists
        //     $user = User::where('email', $request->email)->first();
        //     if($user){
        //         return response()->json([
        //             'message' => 'User already exists'
        //             ], 409);
        //         } 
        //         // create user
        //     $user = User::create([
        //         'name' => $request->name,
        //         'email' => $request->email,
        //         'phone' => $request->phone,
        //         'password' => Hash::make($request->password), 
        //         ]);
                
        //         $response = [
        //             'user' => $user,
        //             'message' => 'User created'
        //             ];
                    
        //             return response($response, 201);
    }

    public function __construct()
    {
        // $this->middleware('auth:sanctum')->except('index');
    }
}
