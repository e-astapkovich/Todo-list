<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255',],
            'email' => ['required', 'string', 'email', 'unique:users', 'max:255',],
            'password' => ['required', 'string', 'min:6', 'confirmed',],
        ]);

        $request['password'] = Hash::make($request->input('password'));
        $newUser = User::create($request->toArray());

        $token = $newUser->createToken('Auth Token')->accessToken;

        return response()->json(['token' => $token]);
    }

    public function login(Request $request) {

        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255',],
            'password' => ['required', 'string', 'min:6',],
        ]);

        if ($user = User::firstWhere('email', $request->input('email'))) {

            if(Hash::check($request->input('password'), $user->password)) {
                $token = $user->createToken('Auth Token')->accessToken;
                return response()->json(['token' => $token]);
            } else {
                return response()->json(['status' => 'wrong login or password'], 401);
            }

        } else {
            return response()->json(['status' => 'user not fonud'], 422);
        }
    }

    public function logout(Request $request) {

        $token = $request->user()->token();
        $token->revoke();
        return response()->json(["status" => "logout successfull"], 200);
    }
}
