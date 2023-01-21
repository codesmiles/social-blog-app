<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\AuthInterface;
use Illuminate\Http\JsonResponse;
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
        // dd($request->only('email', 'password', ));

        // user validation
       $validator= Validator::make(request()->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
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

        $user = $this->AuthRepository->register($data);

        

        return response()->json([
            'user' => $user,
            'message' => 'User created',
        ], Response::HTTP_CREATED);

        
        // or
        /*
        $user = User::create($data);
        
        $response = [
            'user' => $user,
            'message' => 'User created',
        ];
        return response()->json($response,  Response::HTTP_CREATED);
*/
    }

    //--------------------- LOGIN-----------------------
    public function login(Request $request):JsonResponse
    {
        // validate user
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required_with:password|same:password',
        ]);

        // return error if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED); //422
        }
        
        // check if user is logged in and return error if true
        $credentials = request()->only('email', 'password');

        // $user = $this->AuthRepository->login($credentials);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNPROCESSABLE_ENTITY); //422
            
        }
        
        // login users
        return response()->json([
         'message' => 'Logged in',
        'token' => auth()->user()->createToken('auth_token')->plainTextToken,
        ], Response::HTTP_OK);


    }
    //    -----------------------------LOGOUT USER -----------------------------------------
    public function logout(request $request)
    {
        
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out',
        ], Response::HTTP_OK);

    }
}
