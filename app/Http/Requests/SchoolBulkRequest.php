<?php

namespace App\Http\Requests;

use App\Helpers\RolePermissions;
use Illuminate\Foundation\Http\FormRequest;

class SchoolBulkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO: [Subrat] For now, only admin has privileges to add location details. We should add more roles in future here.
        return $this->user()->hasRole([
            RolePermissions::ROLE_ADMIN, 
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            '*.name' => ['required'],
            '*.board' => ['required'],

            '*.village_id' => ['required_without_all:panchayat_id,block_id,city_subarea_id,city_id'],
            '*.panchayat_id' => ['required_without_all:village_id,block_id,city_subarea_id,city_id'],
            '*.block_id' => ['required_without_all:panchayat_id,village_id,city_subarea_id,city_id'],
            '*.city_subarea_id' => ['required_without_all:panchayat_id,block_id,village_id,city_id'],
            '*.city_id' => ['required_without_all:panchayat_id,block_id,village_id,city_subarea_id'],
        ];
    }

    protected function prepareForValidation() {
        $data = [];

        foreach($this->toArray() as $obj) {
            $obj['village_id'] = $obj['villageId'] ?? null;
            $obj['panchayat_id'] = $obj['panchayatId'] ?? null;
            $obj['block_id'] = $obj['blockId'] ?? null;
            $obj['city_subarea_id'] = $obj['citySubareaId'] ?? null;
            $obj['city_id'] = $obj['cityId'] ?? null;
            
            $data[] = $obj;
        }
        
        $this->merge($data);
    }
}