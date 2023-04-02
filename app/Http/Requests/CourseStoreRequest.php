<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
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
        return [
            'name' => ['required'],
            'duration_in_days' => ['required', 'numeric', 'min:1'],
        ];
    }

    protected function prepareForValidation() {
        $this->merge([
            'duration_in_days' => $this->durationInDays,
        ]);
    }
}
?>