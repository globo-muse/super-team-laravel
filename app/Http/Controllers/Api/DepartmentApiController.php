<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentApiResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentApiController extends Controller
{
    public function __construct(private Department $repository)
    {}

    public function index()
    {
        return DepartmentApiResource::collection($this->repository->all());
    }
}
