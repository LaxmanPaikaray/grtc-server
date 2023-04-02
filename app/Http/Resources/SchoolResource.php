<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
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
            'villageId' => $this->village_id,
            'panchayatId' => $this->panchayat_id,
            'blockId' => $this->block_id,
            'citySubareaId' => $this->city_subarea_id,
            'cityId' => $this->city_id,
            'districtId' => $this->district_id,
            'managementBoardId' => $this->management_board_id,
            'board' => $this->board,
            'isActive' => $this->is_active,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'village' => new VillageResource($this->whenLoaded('village')),
            'panchayat' => new PanchayatResource($this->whenLoaded('panchayat')),
            'block' => new BlockResource($this->whenLoaded('block')),
            'citySubarea' => new CitySubareaResource($this->whenLoaded('citySubarea')),
            'city' => new CityResource($this->whenLoaded('city')),
            'district' => new DistrictResource($this->whenLoaded('district')),
            'managementBoard' => new SchoolManagementBoardResource($this->whenLoaded('managementBoard')),
        ];
    }
}
