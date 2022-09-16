<?php

namespace App\Services;

use App\Models\Video;
use App\Repositories\Contracts\VideoRepositoryInterface;
use App\Repositories\VideoRepository;

class VideoService 
{

    protected VideoRepositoryInterface $repository;

    public function __construct(VideoRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    public function getVideoLogoable()
    {
        return $this->repository->getAllLogoPending();
    }


    public function setVideoStatus(Video $video, $newStatus)
    {
        return $this->repository->updateVideoStatus($video, $newStatus);
    }


    public function getVideoById($id)
    {
        return $this->repository->getVideoById($id);
    }
}
