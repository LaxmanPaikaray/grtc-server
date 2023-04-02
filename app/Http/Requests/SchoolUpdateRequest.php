<?php

namespace App\Http\Requests;

use App\Helpers\RolePermissions;
use Illuminate\Foundation\Http\FormRequest;

class SchoolUpdateRequest extends FormRequest
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
        $method = $this->method();
        if($method == 'PUT') {
            return [
                'name' => ['required'],
                'board' => ['required'],

                'village_id' => ['required_without_all:panchayat_id,block_id,city_subarea_id,city_id'],
                'panchayat_id' => ['required_without_all:village_id,block_id,city_subarea_id,city_id'],
                'block_id' => ['required_without_all:panchayat_id,village_id,city_subarea_id,city_id'],
                'city_subarea_id' => ['required_without_all:panchayat_id,block_id,village_id,city_id'],
                'city_id' => ['required_without_all:panchayat_id,block_id,village_id,city_subarea_id'],
            ];
        } else {
            return [
                'name' => ['sometimes', 'required'],
                'board' => ['sometimes', 'required'],
            ];
        }
    }

    protected function prepareForValidation() {
        $validationData = [];
        if($this->villageId) {
            $validationData['village_id'] = $this->villageId;
        }
        if($this->panchayatId) {
            $validationData['panchayat_id'] = $this->panchayatId;
        }
        if($this->blockId) {
            $validationData['block_id'] = $this->blockId;
        }
        if($this->citySubareaId) {
            $validationData['city_subarea_id'] = $this->citySubareaId;
        }
        if($this->cityId) {
            $validationData['city_id'] = $this->cityId;
        }

        $this->merge($validationData);
    }
}
