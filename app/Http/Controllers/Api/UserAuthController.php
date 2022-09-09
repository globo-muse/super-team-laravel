<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserApiResource;
use App\Http\Resources\UserAuthApiResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);
        $client = User::where('email', $request->email)->first();

        if(!$client || !Hash::check($request->password, $client->password)) {
            return response()->json(['message' => 'user nao cadastrado'], 404);
        }

        $token = $client->createToken($request->device_name)->plainTextToken;
        $client->token = $token;
        return response()->json(new UserAuthApiResource($client), 200);
    }


    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json(new UserApiResource($user));
    }
}
