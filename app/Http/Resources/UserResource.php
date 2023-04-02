<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserProfileResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'username'=>$this->username,
            'email'=>$this->email,
            'emailVerifiedAt'=>$this->email_verified_at,
            'accountState'=>$this->account_type,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'profile' => new UserProfileResource($this->whenLoaded('profile')),
            'roles' => $this->roles->pluck('name'),
            'permissions' => $this->permissions->pluck('name'),
        ];
    }
}
