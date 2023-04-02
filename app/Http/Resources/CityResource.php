<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'districtId' => $this->district_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'district' => new DistrictResource($this->whenLoaded('district')),
            'subareas' => CitySubareaResource::collection($this->whenLoaded('subareas')),
        ];
    }
}
