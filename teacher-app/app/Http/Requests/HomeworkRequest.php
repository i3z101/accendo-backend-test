<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeworkRequest extends FormRequest
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
            "homeworkQuestion" => "string|required|min:5|max:150|regex:/^[a-zA-Z\d\s?()%#&]+$/",
        ];
    }

    public function messages()
    {
        return [
            "homeworkQuestion.string" => "Home work should be string only",
            "homeworkQuestion.required" => "Home work question is required",
            "homeworkQuestion.min" => "Home work question should not be less than 5 characters",
            "homeworkQuestion.max" => "Home work question should not exceed 150 characters",
            "homeworkQuestion.regex" => "Home work question can contain string with numbers and ?()%#& symbols"
        ];
    }
}
