<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=>'refreshToken']);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'status'=>'error', 
                'message' => 'Unauthorized'
            ], 401);
        }
    
        $user = Auth::guard('api')->user();
        $token = JWTAuth::claims(['type' => $user->rol])->fromUser($user);
        
        return response()->json([
            'status' => 'success',
            'token' => $token,
        ], 200);
    }

    public function refreshToken()
    {
        try {
            $oldToken = JWTAuth::parseToken();
          
            $email = $oldToken->getPayload()->get('email');
            $user = User::where('email', $email)->first();
            if (!$user || !$user->status) {
              return response()->json([
                'status' => 'error',
                'message' => "Ti-ling, you are inactive",
              ], 401);
            }
          
            $newToken = JWTAuth::fromUser($user, [], true);
          
            return response()->json([
              'status' => 'success',
              'token' => $newToken,
            ], 200);
            
          } catch (\Exception $e) {
            return response()->json([
              'status' => 'error',
              'message' => $e->getMessage(),
            ], 401);
          }
    }
}
