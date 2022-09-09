<?php

namespace App\Http\Resources;

use App\Http\Resources\UserApiResource as ResourcesUserApiResource;

class UserAuthApiResource extends ResourcesUserApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $toArray = parent::toArray($request);
        $toArray['token'] = $this->token;
        // dd($toArray);
        return $toArray;
    }
}
