<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticationTokensController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'device' => 'required'
        ]);

        $user = User::where('email', '=', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {

            $token = $user->createToken($request->device, ['qustions', 'answers']);

            return Response::json([
                'token' => $token->plainTextToken,
                'user' => $user,
            ]);
        }

        return Response::json([
            'message' => 'Invalid email or password',
        ], 401);
    }

    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();
        if ($token) {
            PersonalAccessToken::findToken($token)->delete();
        } else {
            $user->currentAccessToken()->delete();
        }

        return [];
    }
}
