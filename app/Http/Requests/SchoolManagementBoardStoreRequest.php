<?php

namespace App\Http\Requests;

use App\Helpers\RolePermissions;
use Illuminate\Foundation\Http\FormRequest;

class SchoolManagementBoardStoreRequest extends FormRequest
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
        return [
            'name' => ['required'],
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'short_name' => $this->shortName
        ]);
    }
}