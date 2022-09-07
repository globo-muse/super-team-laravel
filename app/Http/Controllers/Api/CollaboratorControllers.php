<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserApiResource;
use App\Models\User;
use Illuminate\Http\Request;

class CollaboratorControllers extends Controller
{

    public function __construct(private User $repository)
    {}

    public function index()
    {
        return UserApiResource::collection($this->repository->all());
    }
}
