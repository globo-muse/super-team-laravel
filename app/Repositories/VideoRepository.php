<?php

namespace App\Repositories;

use App\Models\Video;
use App\Repositories\Contracts\VideoRepositoryInterface;

class VideoRepository implements VideoRepositoryInterface
{
    protected Video $entity;

    public function __construct(Video $entity)
    {
        $this->entity = $entity;
    }

    public function getAllLogoPending()
    {
        return $this->entity->where('status', Video::STATUS_WAITING)->get();
    }

    public function updateVideoStatus(Video $video, string $newStatus)
    {
        return $video->update(['status' => $newStatus]);
    }

    public function getVideoById($id)
    {
        return $this->entity->find($id);
    }
}