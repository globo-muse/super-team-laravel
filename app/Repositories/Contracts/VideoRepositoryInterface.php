<?php

namespace App\Repositories\Contracts;

use App\Models\Video;

interface VideoRepositoryInterface
{
    public function getAllLogoPending();
    public function updateVideoStatus(Video $video, string $newStatus);
    public function getVideoById($id);
}