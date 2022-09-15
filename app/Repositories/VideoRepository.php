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
        return $this->entity->where('status', 'logoable')->get();
    }
}