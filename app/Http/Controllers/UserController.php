<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Response;
use Psy\Util\Json;


class UserController extends Controller
{
    //------------------------------- WELCOME ------------------------------
    public function index()
    {
        return response()->json([
            "message" => "Welcome to the blog API",
            // "update" =>"what's up"

        ]);
    }

//  ----------------------------USER PROFILE -----------------------------------------
    public function profile(Request $request){
        $user = User::where('id', auth()->user()->id)->first();
        return response()->json([
            "message" => "successful",
            "user" => $user
        ], 200);
    }
   
    // ----------------------------SEARCH OTHER USER---------------------------
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

}