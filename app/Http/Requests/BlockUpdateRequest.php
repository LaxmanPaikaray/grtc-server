<?php

namespace App\Http\Requests;

use App\Helpers\RolePermissions;
use Illuminate\Foundation\Http\FormRequest;

class BlockUpdateRequest extends FormRequest
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
                'district_id' => ['required']
            ];
        } else {
            return [
                'name' => ['sometimes', 'required'],
                'district_id' => ['sometimes', 'required']
            ];
        }
    }

    protected function prepareForValidation() {
        if($this->districtId) {
            $this->merge([
                'district_id' => $this->districtId
            ]);
        }
        
    }
}
