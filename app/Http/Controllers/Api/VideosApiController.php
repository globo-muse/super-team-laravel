<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\VideoService;
use Illuminate\Http\Request;

class VideosApiController extends Controller
{

    protected VideoService $service;

    public function __construct(VideoService $videoService)
    {
        $this->service = $videoService;
    }

    public function getAllVideosLogoable()
    {
        $videos = $this->service->getVideoLogoable();
        return response()->json($videos, 200);
    }
}
