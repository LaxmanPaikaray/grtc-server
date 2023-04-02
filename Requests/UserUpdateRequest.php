<?php

namespace App\Http\Requests;

use App\Helpers\RolePermissions;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
                'oldPassword' => ['sometimes', 'required'],
                'password' => ['sometimes', 'required', 'min:5', 'different:oldPassword'],
                'phone' => ['digits:10'],
                'email' => ['email:rfc,dns'],
            ];
        } else {
            return [
                'name' => ['sometimes', 'required'],
                'email' => ['sometimes', 'required', 'email'],
                'phone'=>['sometimes' ,'digits:10'],
                'oldPassword' => ['sometimes', 'required'],
                'password' => ['sometimes', 'required', 'min:5', 'different:oldPassword'],
            ];
        }
    }
}
