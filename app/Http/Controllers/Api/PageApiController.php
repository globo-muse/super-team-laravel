<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageApiResource;
use App\Models\Page;
use Illuminate\Http\Request;

class PageApiController extends Controller
{
    public function __construct(private Page $repository)
    {}

    public function index()
    {
        $pages = $this->repository->all();
        $pagesCollection = PageApiResource::collection($pages);
        return response()->json($pagesCollection);
    }

    public function show($slug)
    {
        if(empty($slug)) {
            return response()->json(['message' => 'slug é required'], 401);
        }
        $page = $this->repository->where('slug', $slug)->first();
        if(!$page) {
            return response()->json(['message' => 'not founded'], 404);
        }
        return response()->json(new PageApiResource($page));
    }
}
