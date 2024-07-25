<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterAuth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=> ['login', 'refreshToken']]);
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
        $token = JWTAuth::claims(['type' => $user->rol, 'email' => $request->email])->fromUser($user);
        
        return response()->json([
            'status' => 'success',
            'token' => $token,
            'userId' => $user->id,
            'rol' => $user->rol,
        ], 200);
    }

    public function register(RegisterAuth $request)
    {
      try{
        User::create([
            'name' => $request->name,
            'last_name' =>  $request->lastName,
            'dni' =>  $request->dni,
            'email' => $request->email,
            'rol' =>  $request->rol,
            'password' => $request->password
        ]);

        return response()->json([
          'status' => 'succes',
          'message' => 'Registrado'
        ], 200);
      }catch(\Exception $e){
        return response()->json([
          'status' => 'error',
          'message' => 'Estamos experimentando problemas'
        ], 500);
      }
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
