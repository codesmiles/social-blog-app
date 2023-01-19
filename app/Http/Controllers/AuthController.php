<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ValidateUserStoreRequest;

// use App\Repository\AuthRepository;
// use App\Interfaces\AuthInterface;




class AuthController extends Controller
{

//! learn to use services file to handle repetitive code
// 1. create a service file
// 2. create a function to handle the repetitive code
// 3. call the function in the controller
// laravel generate a file to keep the repetitive code

// read more laravel documentation



    // public function __construct(AuthInterface $AuthRepository)
// {
//     $this->AuthRepository = $AuthRepository;
// }


    //-------------------------- REGISTER--------------------------------
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse 
    {
        // user validation
       $validator= Validator::make(request()->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'name' => 'required',
            'phone' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422 status code
        }
        
        //  Model, associated array
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ];

        $user = User::create($data);
        
        $response = [
            'user' => $user,
            'message' => 'User created',
        ];
        return response()->json($response,  Response::HTTP_CREATED);

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
