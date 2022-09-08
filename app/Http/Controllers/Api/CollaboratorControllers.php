<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserApiResource;
use App\Models\User;

class CollaboratorControllers extends Controller
{

    public function __construct(private User $repository)
    {}

    public function index()
    {
        $users = $this->repository->with('department')->get();
        return UserApiResource::collection($users);
    }

    public function show($id)
    {
        if(!$user = $this->repository->find($id)) {
            return response()->json(['message' => 'not founded'], 404);
        }
        return new UserApiResource($user);
    }
}
