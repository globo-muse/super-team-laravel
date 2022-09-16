<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoLogoApiResource;
use App\Services\VideoService;
use Exception;
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
        return response(VideoLogoApiResource::collection($videos), 200);
    }

    public function setVideoStatus(Request $request, $id)
    {
        if(!$video = $this->service->getVideoById($id)) {
            return response()->json(['message' => 'video not founded'], 404);
        }
        try {
            $video->update(['status' => $request->status]);
            return response()->json(['messsage' => 'edited with success'], 200);
        } catch(Exception $e) {
            return response()->json(['messsage' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
