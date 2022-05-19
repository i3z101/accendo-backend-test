<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            "studentName" => "string|required|min:2|max:50|regex:/^[a-zA-Z\d_-]+$/",
            "studentPassword" => "string|required|min:8|max:15|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&^_-]+$/"
        ];
    }

    public function messages()
    {
        return [
            "studentName.string" => "Student name should be string only",
            "studentName.required" => "Student name is required",
            "studentName.min" => "Student name should not be less than 2 characters",
            "studentName.max" => "Student name should not exceed 50 characters",
            "studentName.regex" => "Student name should contain only string charaters and digits without spacing",
            "studentPassword.string" => "Student password should be string only",
            "studentPassword.required" => "Student password is required",
            "studentPassword.min" => "Student password should not be less than 8 characters",
            "studentPassword.max" => "Student password should not exceed 15 characters",
            "studentPassword.regex" => "Student password should contain at least on upper case, one lower case, one digit, and one symbol character",
        ];
    }
}
