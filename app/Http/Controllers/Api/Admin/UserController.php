<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {
        $users = User::all()->except(Auth::id());

        return response()->json([
            'status' => true,
            'users' => $users
        ]);
    }

    public function update(Request $request, User $user) {

        try {

            $validated = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required'
            ]);

            if($validated->fails()) {
                return response()->json([
                    'status' => true,
                    'message' => 'validate error',
                    'user' => $user
                ]);
            }

            $user->update($request->all());

            return response()->json([
                'status' => true,
                'message' => "user updated",
                'users' => $user
            ]);

        } catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }

    }

    
    public function destroy(User $user) {
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'user deleted',
            'users' => $user
        ]);
    }
}
