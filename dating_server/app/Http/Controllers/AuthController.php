<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;
use League\Config\Exception\ValidationException;

class AuthController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request) {
        try {
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);
            $credentials = $request->only('username', 'password');
    
            $token = Auth::attempt($credentials);
            if (!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ], 401);
            }
    
            $user = Auth::user();
            return response()->json([
                    'status' => 'success',
                    'user' => $user,
                    'authorisation' => [
                        'token' => $token,
                        'type' => 'bearer',
                    ]
                ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                // 'msg'    => 'Error',
                'errors' => $exception->getMessage(),
            ], 422);
        }
        

    }

    public function register(Request $request) {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'gender' => 'required|string',
                'interested_in' => 'required|string',
                'Latitude' => 'required|string',
                'Longitude' => 'required|string',
                'password' => 'required|string|min:6',
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'gender' => $request->gender,
                'interested_in' => $request->interested_in,
                'Latitude' => $request->Latitude,
                'Longitude' => $request->Longitude,
                'password' => Hash::make($request->password),
            ]);
    
            $token = Auth::login($user);
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                // 'msg'    => 'Error',
                'errors' => $exception->getMessage(),
            ], 422);
        }
        
    }

    public function logout() {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh() {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
