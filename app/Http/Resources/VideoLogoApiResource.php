<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoLogoApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'ID' => $this->id,
            'order_id' => $this->order_id,
            'hash' => $this->hash,
            'vimeo_file_play' => $this->link_play,
            'video_logo_status' => $this->status,
            'campaign' => '',
        ];
    }
}
