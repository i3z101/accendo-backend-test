<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolutionRequest extends FormRequest
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
            "solution" => "string|required|min:3,max:500|regex:/^[a-zA-Z\s\d%^&*(),]+$/"
        ];
    }
    
    public function messages()
    {
        return [
            "solution.string" => "Solution must be string only",
            "solution.required" => "Solution is required",
            "solution.min" => "Solution should not be less than 3 characters",
            "solution.max" => "Solution should not exceed 500 characters",
            "solution.regex" => "Solution should contain string or numbers and one of these symbols %^&*(), "
        ];
    }
}
