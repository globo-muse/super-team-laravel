<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserUpdateApiRequest;
use App\Http\Resources\UserApiResource;
use App\Http\Resources\UserAuthApiResource;
use App\Jobs\ForgotPasswordJob;
use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserAuthController extends Controller
{


    public function __construct(
        protected User $repository,
        protected UserService $userService,
    ) {}


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
    

    public function updateMe(UserUpdateApiRequest $request)
    {
        $user = $request->user();
        $userData = $request->all();
        $userData['image'] = $request->image;
        $this->userService->updateUser($user->id, $userData);
    }


    // public function forgetPassword(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email'
    //     ]);

    //     // $status = Password::sendResetLink(
    //     //     $request->only('email')
    //     // );

    //     $email = $request['email'];
    //     $token = Str::random(64);

    //     DB::table('password_resets')->insert([
    //         'email' => $email, 
    //         'token' => $token, 
    //         'created_at' => Carbon::now()
    //     ]);

    //     //TODO: SEND A EMAIL WiTH A LINK
    //     ForgotPasswordJob::dispatch($email, $token);

    //     return response()->json(['message' => 'the email will send soon'], 200);

    //     // return $status === Password::RESET_LINK_SENT
    //     //     ? response()->json(['message' => 'ok'], 200)
    //     //     : response()->json(['message' => 'error'], 500);
    // }


    public function resetPassword(Request $request)
    {
        // $token = $request['token'];
        if(!$request->validate(['email' => 'required|email'])) {
            return response(['caca'], 400);
        }
        $email = $request['email'];
        
        // $password = $request['password'];
        // $checkPassword = $request['chackePassword'];

        // $dbData = DB::table('password_resets')->where('email', $email)->latest();
        // if(!$dbData || $dbData->token !== $token) {
        //     return response()->json(['error' => 'error', 404]);
        // }

        // if($password !== $checkPassword) {
        //     return response()->json(['error' => 'password dont match', 404]);
        // }

        // $user = User::query()->where('email', $email)->first();
        // $user->update(['password' => Hash::make($password)]);;
        // return response()->json(['message' => 'ok', 201]);

        if(!$user = $this->repository->where('email', $email)->first()) {
            return response()->json(['message' => 'email sended (1)']);
        }
        
        $newPassword = Str::random(8);
        $user->update(['password' => Hash::make($newPassword)]);

        ForgotPasswordJob::dispatch($email, $newPassword);
        return response()->json(['message' => 'email will sended with a new password']);
    }
}
