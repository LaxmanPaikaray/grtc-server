<?php

namespace App\Http\Requests;

use App\Helpers\RolePermissions;
use Illuminate\Foundation\Http\FormRequest;

class VillageUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO: [Subrat] For now, only admin has privileges to add location details. We should add more roles in future here.
        return $this->user()->hasRole([RolePermissions::ROLE_ADMIN]);
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
                'panchayat_id' => ['required']
            ];
        } else {
            return [
                'name' => ['sometimes', 'required'],
                'panchayat_id' => ['sometimes', 'required']
            ];
        }
    }

    protected function prepareForValidation() {
        if($this->panchayatId) {
            $this->merge([
                'panchayat_id' => $this->panchayatId
            ]);
        }
        
    }
}