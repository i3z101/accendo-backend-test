<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            "teacherName" => "string|required|min:2|max:50|regex:/^[a-zA-Z\d_-]+$/",
            "teacherPassword" => "string|required|min:8|max:15|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&^_-]+$/"
        ];
    }

    public function messages()
    {
        return [
            "teacherName.string" => "Teacher name should be string only",
            "teacherName.required" => "Teacher name is required",
            "teacherName.min" => "Teacher name should not be less than 2 characters",
            "teacherName.max" => "Teacher name should not exceed 50 characters",
            "teacherName.regex" => "Teacher name should contain only string charaters and digits without spacing",
            "teacherPassword.string" => "Teacher password should be string only",
            "teacherPassword.required" => "Teacher password is required",
            "teacherPassword.min" => "Teacher password should not be less than 8 characters",
            "teacherPassword.max" => "Teacher password should not exceed 15 characters",
            "teacherPassword.regex" => "Teacher password should contain at least on upper case, one lower case, one digit, and one symbol character",
        ];
    }
}
