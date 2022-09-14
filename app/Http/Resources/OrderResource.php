<?php

namespace App\Http\Resources;

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
            'user_id' => new UserApiResource($this->user),
            'responder' => new UserApiResource($this->responder),
            'name' => $this->name,
            'email' => $this->email,
            'occasion' => $this->occasion,
            'instructions' => $this->instructions,
            'date' => $this->created_at
        ];
    }
}
