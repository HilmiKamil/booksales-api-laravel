<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request)
    {
        // Setup Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8'
        ]);
        // Check Validator
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //Cek Keberhasilan
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User Created Succesfully',
                'data' => $user
            ], 201);
        }

        //Cek Kegagalan
        return response()->json([
            'sucess' => false,
            'message' => 'User Creation Faild'
        ], 409);
    }

    public function login(Request $request)
    {
        // Setupun Validatior
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek Validator
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Get Kredensial dari Request
        $credentials = $request->only('email', 'password');

        // Cek isFailed
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Your Email and Password False'
            ], 401);
        }

        // Cek isSuccess
        return response()->json([
            'success' => true,
            'message' => 'Login Successfully',
            'user' => auth()->guard('api')->user(),
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'message' => 'Logout Successfully!'
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout Failed'
            ], 500);
        }
    }
}
