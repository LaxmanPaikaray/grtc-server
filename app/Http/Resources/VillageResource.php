<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class  VillageResource extends JsonResource
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
            'panchayatId' => $this->panchayat_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'panchayat' => new PanchayatResource($this->whenLoaded('panchayat')),
        ];
    }
}
