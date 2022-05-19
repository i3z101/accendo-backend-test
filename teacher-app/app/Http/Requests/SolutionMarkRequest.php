<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolutionMarkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            "mark" => "numeric|required|min:0|max:100|regex:/^([0-9]*[.])?[0-9]+$/"
        ];
    }

    public function messages()
    {
        return [
            "mark.numeric" => "Mark should be numeric only",
            "mark.required" => "mark is required",
            "mark.min" => "Mark should not be less than 0",
            "mark.max" => "Mark should not exceed 100",
            "mark.regex" => "Mark should only contain numeric values between 0 - 100"
        ];
    }
}
