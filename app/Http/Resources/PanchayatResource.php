<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class  PanchayatResource extends JsonResource
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
            'slug' => $this->slug,
            'blockId' => $this->block_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'block' => new BlockResource($this->whenLoaded('block')),
            'villages' => VillageResource::collection($this->whenLoaded('villages')),
        ];
    }
}
