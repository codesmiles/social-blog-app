<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Interfaces\UserInterface;


class UserController extends Controller
{
    private UserInterface $UserRepository;
    public function __construct(UserInterface $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    //------------------------------- WELCOME ------------------------------
    public function index()
    {
        return $this->UserRepository->welcome();
        
    }

//  ----------------------------USER PROFILE -----------------------------------------
    public function profile(Request $request){
        $user = $this->UserRepository->profile($request);

        return response()->json([
            "message" => "successful",
            "user" => $user,
            "friends" => $user->friends,
        ], 200);
    }
   
    // ----------------------------SEARCH OTHER USER---------------------------
    public function search(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
        ]);

        $user = $this->UserRepository->search($request);
        

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