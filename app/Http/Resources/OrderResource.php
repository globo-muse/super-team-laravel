<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id' => $this->id,
            'user' => new UserApiResource($this->user),
            'user_id' => $this->user_id,
            'responder' => new UserApiResource($this->responder),
            'responder_id' => $this->responder_id,
            'name' => $this->name,
            'email' => $this->email,
            'occasion' => $this->occasion,
            'instructions' => $this->instructions,
            'video_link' => $this->video_link ?? null,
            'date' => $this->created_at,
        ];
    }
}
