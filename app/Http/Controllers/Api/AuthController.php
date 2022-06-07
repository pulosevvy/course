<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class AuthController extends Controller {
    
    public function register(Request $request){
        
        try {

            $validated = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            
            ]);

            if($validated->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validate error',
                    'error' => $validated->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 12
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);


            } catch(\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ]);
            }


    }

    public function login(Request $request){

        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
            
        }
    
    }

    public function logout() {

        Auth::user()->tokens()->delete();
    
        return response()->json( [
            'message' => 'User LogOut In Successfully'
        ]);

    }

}
