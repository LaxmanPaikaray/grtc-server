<?php

namespace App\Http\Requests;

use App\Helpers\RolePermissions;
use Illuminate\Foundation\Http\FormRequest;

class SchoolStoreRequest extends FormRequest
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
            'name' => ['required'],
            'board' => ['required'],

            'village_id' => ['required_without_all:panchayat_id,block_id,city_subarea_id,city_id'],
            'panchayat_id' => ['required_without_all:village_id,block_id,city_subarea_id,city_id'],
            'block_id' => ['required_without_all:panchayat_id,village_id,city_subarea_id,city_id'],
            'city_subarea_id' => ['required_without_all:panchayat_id,block_id,village_id,city_id'],
            'city_id' => ['required_without_all:panchayat_id,block_id,village_id,city_subarea_id'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'village_id' => $this->villageId,
            'panchayat_id' => $this->panchayatId,
            'block_id' => $this->blockId,
            'city_subarea_id' => $this->citySubareaId,
            'city_id' => $this->cityId,
        ]);
    }
}
