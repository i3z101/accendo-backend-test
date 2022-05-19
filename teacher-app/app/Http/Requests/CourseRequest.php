<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CourseRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }

    // public function withValidator(Validator $validator) {
    //     $validator->after(function($validator) {
    //         if ($this->somethingElseIsInvalid()) {
    //             $validator->errors()->add('field', 'Something is wrong with this field!');
    //         }
    //     });
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "courseName" => "string|required|min:2,max:100|regex:/^[a-zA-Z\d\s]+$/"
        ];
    }

    public function messages()
    {
        return [
            "courseName.string" => "Course name should only contain string characters",
            "courseName.required" => "Course name is required",
            "courseName.min" => "Course name should have 2 characters at least have",
            "courseName.max" => "Course name should have 100 characters at maximum",
            "courseName.regex" => "Course name should only contain string, digist, and spaces"
        ];
    }
}
