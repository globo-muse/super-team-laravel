<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $userData = UserApiResource::collection($this->users);
        // if(count($userData)) {
        //     dd($userData);
        //     return;
        // }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'users' => $userData ?? null,
        ];
    }
}
