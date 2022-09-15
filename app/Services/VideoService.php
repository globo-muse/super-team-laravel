<?php

namespace App\Services;

use App\Repositories\VideoRepository;

class VideoService 
{

    protected VideoRepository $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }


    public function getVideoLogoable()
    {
        return $this->repository->getAllLogoPending();
    }
}
