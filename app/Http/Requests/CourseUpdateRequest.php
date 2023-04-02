<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO: [Subrat] temporarily set to true - until we implement authorization
        return true;
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
                'duration_in_days' => ['required'],
            ];
        } else {
            return [
                'name' => ['sometimes', 'required'],
                'duration_in_days' => ['sometimes', 'required'],
            ];
        }
    }

    protected function prepareForValidation() {
        $validationData = [];
        if($this->durationInDays) {
            $validationData['duration_in_days'] = $this->durationInDays;
        }
        
        $this->merge($validationData);
    }
}
?>