<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
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
            'stateId' => $this->state_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'state' => new StateResource($this->whenLoaded('state')),
            'cities' => CityResource::collection($this->whenLoaded('cities')),
            'blocks' => BlockResource::collection($this->whenLoaded('blocks')),
        ];
    }
}
