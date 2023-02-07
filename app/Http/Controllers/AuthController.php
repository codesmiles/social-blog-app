<?php

namespace App\Http\Controllers;

use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// use App\Http\Requests\ValidateUserStoreRequest;

class AuthController extends Controller
{

//! learn to use services file to handle repetitive code
// 1. create a service file
// 2. create a function to handle the repetitive code
// 3. call the function in the controller
// laravel generate a file to keep the repetitive code

// read more laravel documentation

    private AuthInterface $AuthRepository;
    public function __construct(AuthInterface $AuthRepository)
    {
        $this->AuthRepository = $AuthRepository;
    }

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
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'name' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422 status code
        }

        //  Model, associated array
        $user = $this->AuthRepository->register([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        
        return response()->json([
            'user' => $user,
            'message' => 'User created',
        ], Response::HTTP_CREATED);

    }

    //--------------------- LOGIN-----------------------
    public function login(Request $request): JsonResponse
    {
        // validate user
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required_with:password|same:password',
        ]);

        // return error if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED); //422
        }
        $login = $this->AuthRepository->login($request);

        // login users
        return response()->json($login, Response::HTTP_OK);

    }

    // forgot password
    public function forgotPassword(Request $request)
    {
        // validate user
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        // return error if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED); //422
        }

    }

    //    -----------------------------LOGOUT USER -----------------------------------------
    public function logout()
    {
        // delete all tokens
        $this->AuthRepository->logout();        

        return response()->json([
            'message' => 'Logged out',
        ], Response::HTTP_OK);

    }
}
